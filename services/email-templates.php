<?php

$email_templates = [
	'e-price' => [
		'subject' => "New Quotation Request from [first_name] [last_name] - AI [company_name]",
		'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Question:[comments]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
		'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
		'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
	],
	'e-price-mainlinechrysler' => [
		'subject' => "New Quotation Request from [first_name] [last_name] - AI [company_name]",
		'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Question:[comments]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
		'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
		'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
	],
	'e-price-phone_optional' => [
        'subject' => "New Quotation Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Question:[comments]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'e-price-v2' => [
        'subject' => "New Quotation Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Question:[comments]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Marketing Consent: [marketing-consent]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'e-price-new' => [
        'subject' => "New Quotation Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Question:[comments]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
	'finance' => [
		'subject' => "New Finance Request from [first_name] [last_name] - AI [company_name]",
		'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Address:[address]<br/>DOB: [dob_day], [dob_month] [dob_year]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
		'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
		'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
	],
	'finance-mainlinechrysler' => [
		'subject' => "New Finance Request from [first_name] [last_name] - AI [company_name]",
		'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Address:[address]<br/>DOB: [dob_day], [dob_month] [dob_year]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
		'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
		'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
	],
	'finance-phone_optional' => [
        'subject' => "New Finance Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Address:[address]<br/>DOB: [dob_day], [dob_month] [dob_year]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'finance-new' => [
        'subject' => "New Finance Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Address:[address]<br/>DOB: [dob_day], [dob_month] [dob_year]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'lease' => [
        'subject' => "New Lease Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Address:[address]<br/>DOB: [dob_day], [dob_month] [dob_year]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'lease-new' => [
        'subject' => "New Lease Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Address:[address]<br/>DOB: [dob_day], [dob_month] [dob_year]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'test-drive' => [
        'subject' => "New Test Drive Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Appointment Date:[appointment_date]<br/> Question:[comments]<br/>Address:[address]<br/>Vehicle Use: [vehicle_use]<br/>Living: [living]<br/>Living Since: [living_since]<br/>Mortgage/Rent Payment: [mortgage_payment]<br/>Marital Status: [marital_status]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
                <?adf version="1.0"?>
                <adf>
                    <prospect>
                        <id sequence="[total_count]" source="sMedia"></id>
                        <requestdate>[fdt]</requestdate>
                        <vehicle interest="buy" status="[stock_type]">
                            <year>[year]</year>
                            <make>[make]</make>
                            <model>[model]</model>
                            <stock>[stock_number]</stock>
                        </vehicle>

                       <customer>
                           <contact>
                                <name part="first">[first_name]</name>
                                <name part="last">[last_name]</name>
                                <email>[email]</email>
                                <phone>[phone]</phone>
                            </contact>
                            <comments>[comments]. Appointment Date:[appointment_date]. Button Clicked: [button_text]. Sent From: [url]</comments>
                       </customer>

                        <vendor>
                            <vendorname>[company_name]</vendorname>
                            <contact>
                                <name part="full">[company_name]</name>
                                <email>[company_email]</email>
                            </contact>
                        </vendor>
                        <provider>
                            <name part="full">sMedia :: [button_name]</name>
                            <url>https://smedia.ca</url>
                            <email>offer@smedia.ca</email>
                            <phone>855-775-0062</phone>
                        </provider>
                    </prospect>
                </adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
          <ns:ApplicationArea>
            <ns:Sender>
              <ns:URI>[url]</ns:URI>
            </ns:Sender>
            <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
          </ns:ApplicationArea>
          <ns:ProcessSalesLeadDataArea>
            <ns:SalesLead>
              <ns:SalesLeadHeader>
                <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
                <ns:CustomerProspect>
                  <ns:ProspectParty>
                    <ns:SpecifiedPerson>
                      <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
                      <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
                      <ns:TelephoneCommunication>
                        <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
                      </ns:TelephoneCommunication>
                    </ns:SpecifiedPerson>
                  </ns:ProspectParty>
                  <ns:CurrentlyOwnedItem>
                    <ns:OwnedVehicleDetail>
                      <ns:SalesLeadOwnedVehicle>
                        <ns:Vehicle>
                          <ns:Model languageID="string">[make]</ns:Model>
                          <ns:ModelYear>[year]</ns:ModelYear>
                          <ns:MakeString>[model]</ns:MakeString>
                          <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                          <ns:Condition languageID="string">[stock_type]</ns:Condition>
                        </ns:Vehicle>
                      </ns:SalesLeadOwnedVehicle>
                    </ns:OwnedVehicleDetail>
                  </ns:CurrentlyOwnedItem>
                </ns:CustomerProspect>
              </ns:SalesLeadHeader>
            </ns:SalesLead>
          </ns:ProcessSalesLeadDataArea>
        </ns:ProcessSalesLead>'
    ],
    'test-drive-v2' => [
        'subject' => "New Test Drive Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Appointment Date:[appointment_date] <br/>Question:[comments]<br/>Address:[address]<br/>Vehicle Use: [vehicle_use]<br/>Living: [living]<br/>Living Since: [living_since]<br/>Mortgage/Rent Payment: [mortgage_payment]<br/>Marital Status: [marital_status]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Marketing Consent: [marketing-consent]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Appointment Date:[appointment_date]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'test-drive-new' => [
        'subject' => "New Test Drive Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Appointment Date:[appointment_date]<br/>Question:[comments]<br/>Address:[address]<br/>Vehicle Use: [vehicle_use]<br/>Living: [living]<br/>Living Since: [living_since]<br/>Mortgage/Rent Payment: [mortgage_payment]<br/>Marital Status: [marital_status]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Appointment Date:[appointment_date]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'trade-in' => [
        'subject' => "New Trade In Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Interested In: [year] [make] [model]<br/>Trade In: [trade_year] [trade_make] [trade_model]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="trade-in" status="[stock_type]">
            <year>[trade_year]</year>
            <make>[trade_make]</make>
            <model>[trade_model]</model>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'trade-in-v2' => [
        'subject' => "New Trade In Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Interested In: [year] [make] [model]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Considering trading in my current vehicle: [considering-tradein]<br/> I may qualify for GM Preferred Pricing : [qualify-gm-pricing]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="trade-in" status="[stock_type]">
            <year>[trade_year]</year>
            <make>[trade_make]</make>
            <model>[trade_model]</model>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'trade-in-new' => [
        'subject' => "New Trade In Request from [first_name] [last_name] - AI [company_name]",
        'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Interested In: [year] [make] [model]<br/>Trade In: [trade_year] [trade_make] [trade_model]<br/>Sent From: [url]<br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="trade-in" status="[stock_type]">
            <year>[trade_year]</year>
            <make>[trade_make]</make>
            <model>[trade_model]</model>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]. Button Clicked: [button_text]. Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[company_name]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
        'STAR' => '<ns:ProcessSalesLead releaseID="string" versionID="string" systemEnvironmentCode="Production" languageCode="en-US" xmlns:ns="http://www.starstandard.org/STAR/5" xmlns:ns1="http://www.openapplications.org/oagis/9">
  <ns:ApplicationArea>
    <ns:Sender>
      <ns:URI>[url]</ns:URI>
    </ns:Sender>
    <ns:CreationDateTime>[fdt]</ns:CreationDateTime>
  </ns:ApplicationArea>
  <ns:ProcessSalesLeadDataArea>
    <ns:SalesLead>
      <ns:SalesLeadHeader>
        <ns:CustomerComments languageID="string">[comments]</ns:CustomerComments>
        <ns:CustomerProspect>
          <ns:ProspectParty>
            <ns:SpecifiedPerson>
              <ns:FamilyName languageID="string">[first_name]</ns:FamilyName>
              <ns:MiddleName languageID="string">[last_name]</ns:MiddleName>
              <ns:TelephoneCommunication>
                <ns:CompleteNumber languageID="string">[phone]</ns:CompleteNumber>
              </ns:TelephoneCommunication>
            </ns:SpecifiedPerson>
          </ns:ProspectParty>
          <ns:CurrentlyOwnedItem>
            <ns:OwnedVehicleDetail>
              <ns:SalesLeadOwnedVehicle>
                <ns:Vehicle>
                  <ns:Model languageID="string">[make]</ns:Model>
                  <ns:ModelYear>[year]</ns:ModelYear>
                  <ns:MakeString>[model]</ns:MakeString>
                  <ns:VehicleStockString>[stock_number]</ns:VehicleStockString>
                  <ns:Condition languageID="string">[stock_type]</ns:Condition>
                </ns:Vehicle>
              </ns:SalesLeadOwnedVehicle>
            </ns:OwnedVehicleDetail>
          </ns:CurrentlyOwnedItem>
        </ns:CustomerProspect>
      </ns:SalesLeadHeader>
    </ns:SalesLead>
  </ns:ProcessSalesLeadDataArea>
</ns:ProcessSalesLead>'
    ],
    'smart-offer' => [
        'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="[source]"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
            <vin>[vin]</vin>
            <trim>[trim]</trim>
            <doors>[doors]</doors>
            <bodystyle>[body_style]</bodystyle>
            <transmission>[transmission]</transmission>
			<odometer status="[odo_status]" units="km">[odometer]</odometer>
        </vehicle>

       <customer>
           <contact>
                <name part="full">[name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>Sent From: [url]</comments>
       </customer>

        <vendor>
            <vendorname>[dealership]</vendorname>
            <contact>
                <name part="full">[company_name]</name>
                <email>[dealer_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">[provider_name]</name>
            <form>sMedia Coupon</form>
            <url>https://smedia.ca</url>
            <email>offer@smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>'
    ]
];
