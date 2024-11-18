<?php

require_once __DIR__ . "/TagCodes.php";
require_once __DIR__ . "/SWFTagCollection.php";

class SWFEditor
{
    #region Properties
    public $Content, $Filename, $SWFType, $Version, $FileSize, $FrameWidth, $FrameHeight, $FrameRate,
        $FrameCount;

    private $FrameOffset;

    #region Constractor Destractors
    public function __construct($filename)
    {
        $this->Filename = $filename;

        if (is_file($filename) && file_exists($filename)) {
            $this->Content = file_get_contents($filename);

            if ($this->Content[1] == "W" && $this->Content[2] == "S") {
                switch ($this->Content[0]) {
                    case "F":
                        $this->SWFType = SWFType::Uncompressed;
                        break;
                    case "C":
                        $this->SWFType = SWFType::ZLIBCompressed;
                        $this->Content = substr($this->Content, 0, 8) . gzuncompress(substr($this->Content, 8));
                        break;
                    case "Z":
                        $this->SWFType = SWFType::LZMACompressed;
                        break;
                    default:
                        $this->SWFType = SWFType::Unknown;
                        break;
                }
            }

            if ($this->SWFType == SWFType::LZMACompressed) {
                throw new Exception("I am not ready to process LZMACompressed SWF file");
            }

            if ($this->SWFType) {
                $this->Version  = ord($this->Content[3]);
                $file_size_temp = unpack("V", substr($this->Content, 4, 4));
                $this->FileSize = $file_size_temp[1];

                //get size
                $NBits  = ord($this->Content[8]) >> 3;
                $offset = 8 * 8 + 5;

                $Xmin = $this->bits2int($offset, $NBits);
                $offset += $NBits;

                $Xmax = $this->bits2int($offset, $NBits);
                $offset += $NBits;

                $Ymin = $this->bits2int($offset, $NBits);
                $offset += $NBits;

                $Ymax = $this->bits2int($offset, $NBits);
                $offset += $NBits;

                $this->FrameWidth  = (($Xmax - $Xmin) / 20);
                $this->FrameHeight = (($Ymax - $Ymin) / 20);

                //frame rate
                $byte_offset     = $this->getByteOffset($offset);
                $this->FrameRate = ord($this->Content[$byte_offset + 1]);
                $byte_offset += 2;

                //number of frames
                $frame_count_temp = unpack("v", substr($this->Content, $byte_offset, 2));
                $this->FrameCount = $frame_count_temp[1];
                $byte_offset += 2;

                $this->FrameOffset = $byte_offset;
            }
        } else {
            $this->Content = null;
            $this->SWFType = SWFType::Unknown;
        }
    }

    #region private functions
    private function getByteOffset($bit_offset)
    {
        if ($bit_offset % 8 != 0) {
            $bit_offset += (8 - ($bit_offset % 8));
        }

        return $bit_offset / 8;
    }

    private function bits2int($offset, $length)
    {
        $s = (ord($this->Content[intval($offset / 8)]) >> (7 - $offset % 8)) & 1;

        $r = 0;

        for ($i = $offset + 1; $i < $offset + $length; $i++) {
            $b = (ord($this->Content[intval($i / 8)]) >> (7 - $i % 8)) & 1;
            $r = ($r << 1) + ($s ? !$b : $b);
        }

        if ($s) {
            $r++;
            $r = -$r;
        }

        return $r;
    }

    private function ReadTag($offset)
    {
        $tagCLTemp = unpack("v", substr($this->Content, $offset, 2));
        $tagCL     = $tagCLTemp[1];
        $tagCode   = $tagCL >> 6;
        $length    = $tagCL & 0x003f;

        $tagType = TagType::ShortTag;

        if ($length == 0x3f) {
            $lengthTemp = unpack("V", substr($this->Content, $offset + 2, 4));
            $length     = $lengthTemp[1];
            $tagType    = TagType::LongTag;
        }

        return new SWFTagInfo($tagCode, $tagType, $offset, $length);
    }

    #region public functions
    public function getTags()
    {
        $tags = [];
        $offset = $this->FrameOffset;

        while ($offset < strlen($this->Content)) {
            $tag                = $this->ReadTag($offset);
            $tags[count($tags)] = $tag;

            $new_offset = $tag->DataOffset + $tag->Length;

            if ($new_offset < 0) {
                break;
            } else {
                $offset = $new_offset;
            }
        }

        return $tags;
    }

    public function getTagData(SWFTagInfo $tag)
    {
        return substr($this->Content, $tag->DataOffset, $tag->Length);
    }

    public function getTagDataEx(SWFTagInfo $tag)
    {
        global $Tags;

        $data = $this->getTagData($tag);

        if (isset($Tags[$tag->TagCode])) {
            return $Tags[$tag->TagCode]->read($data);
        } else {
            return $data;
        }
    }

    public function replaceTag(SWFTagInfo $old_tag, $tagCode, $tagType, $data)
    {
        $tagCL = $tagCode << 6;

        if ($tagType == TagType::LongTag) {
            $tagCL |= 0x3f;
        } else {
            $tagCL |= strlen($data);
        }

        if ($tagType == TagType::ShortTag && strlen($data) > 62) {
            throw new Exception("Tag type does not support more than 62 bytes of data");
        }

        $tagData = pack("v", $tagCL);

        if ($tagType == TagType::LongTag) {
            $tagData .= pack("V", strlen($data));
        }

        $tagData .= $data;

        $this->Content = substr($this->Content, 0, $old_tag->Offset) . $tagData . substr($this->Content, $old_tag->DataOffset + $old_tag->Length);

        $file_size = strlen($this->Content);

        $file_size_bytes = pack("V", $file_size);

        for ($i = 0; $i < 4; $i++) {
            $this->Content[$i + 4] = $file_size_bytes[$i];
        }

        $this->FileSize = $file_size;
    }

    public function replaceTagEx(SWFTagInfo $old_tag, $tagCode, $tagType, $object)
    {
        global $Tags;

        $data = $object;

        if (isset($Tags[$tagCode])) {
            $data = $Tags[$tagCode]->write($object);
        }

        $this->replaceTag($old_tag, $tagCode, $tagType, $data);
    }

    public function write($filename = null)
    {
        if ($this->SWFType == SWFType::ZLIBCompressed) {
            $data = substr($this->Content, 0, 8) . gzcompress(substr($this->Content, 8));
        } else {
            $data = $this->Content;
        }

        if ($filename) {
            file_put_contents($filename, $data);
        } else {
            echo $data;
        }
    }
}

class SWFTagInfo
{
    public $TagCode, $TagType, $Offset, $Length;

    public function __construct($tagCode, $tagType, $offset, $length)
    {
        $this->TagCode = $tagCode;
        $this->TagType = $tagType;
        $this->Offset  = $offset;
        $this->Length  = $length;
    }

    public function __get($name)
    {
        if ($name == 'DataOffset') {
            return $this->Offset + ($this->TagType == TagType::ShortTag ? 2 : 6);
        }
    }
}

class TagType
{
    const ShortTag = 1;
    const LongTag  = 2;
}

class SWFType
{
    const Unknown        = 0;
    const Uncompressed   = 1;
    const ZLIBCompressed = 2;
    const LZMACompressed = 4;
}
