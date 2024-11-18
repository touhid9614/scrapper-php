<?php

namespace sMedia\AbTest;

use Illuminate\Database\Capsule\Manager as DB;

class AbTestController
{
    public $dealership;
    public $debug;
    public $testDir;
    public $tests;
    public $configs;
    public $haveTests;
    public $haveConfig;
    private $availableTests;
    private $table = 'tbl_ab_test_configs';

    public function __construct($dealership, $url, $test_dir)
    {
        $this->haveTests      = false;
        $this->haveConfig     = false;
        $this->tests          = [];
        $this->availableTests = [];

        $this->dealership = $dealership;
        $url              = parse_url(urldecode($url));

        if (isset($url['query'])) {
            $queries = explode('&', $url['query']);

            foreach ($queries as $query) {
                $parts = explode('=', $query);

                if (isset($parts[0]) && $parts[0] == 'ab_debug') {
                    if (isset($parts[1]) && !empty($parts[1])) {
                        $debug = json_decode($parts[1], true);

                        if (is_array($debug)) {
                            $this->debug = $debug;
                        }
                    }
                }
            }
        }

        $this->testDir = $test_dir;
        $this->loadTestConfig();
    }

    private function loadTests()
    {
        $all_ab_tests  = [];
        $ab_test_files = glob("{$this->testDir}/tests/*.php");

        foreach ($ab_test_files as $file) {
            require $file;
            $this->haveTests = true;
        }

        $this->availableTests = $all_ab_tests;
        unset($all_ab_tests);
    }

    private function loadTestConfig()
    {
        $this->loadTests();
        $rows    = DB::table($this->table)->where('dealership', '=', $this->dealership)->get();
        $configs = [];

        foreach ($rows as $row) {
            $configs[$row->type][] = $row->option;
            $this->haveConfig      = true;
        }

        $this->configs = isset($this->debug) ? array_merge($configs, $this->debug) : $configs;
    }

    public function updateConfig($new_configs)
    {
        $this->loadTestConfig();
        $options = [];

        foreach ($new_configs as $type_name => $type_configs) {
            foreach ($type_configs['options'] as $option_name => $option_status) {
                if ($type_configs['active'] == 'true' && $option_status == 'true') {
                    $options[] = ['dealership' => $this->dealership, 'type' => $type_name, 'option' => $option_name];
                }
            }
        }

        DB::table($this->table)->where('dealership', '=', $this->dealership)->delete();
        DB::table($this->table)->insert($options);
    }

    public function getOptions()
    {
        $this->loadTestConfig();
        $options = [];

        foreach ($this->availableTests as $test_type => $test_configs) {
            if ($test_configs['active'] == true) {
                $test_active         = array_key_exists($test_type, $this->configs) ? true : false;
                $options[$test_type] = ['name' => $test_configs['name'], 'active' => $test_active];
                foreach ($test_configs['options'] as $option_name => $option_config) {
                    if ($option_config['active'] == true) {
                        $options[$test_type]['options'][$option_name]           = $option_config;
                        $options[$test_type]['options'][$option_name]['active'] = $test_active && in_array($option_name, $this->configs[$test_type]) ? true : false;
                    }
                }
            }
        }

        return $options;
    }

    public function getJavascripts()
    {
        $scripts = [];

        foreach ($this->configs as $test_type => $options) {
            if (isset($this->availableTests[$test_type])) {
                foreach ($options as $option) {
                    if (isset($this->availableTests[$test_type]['options'][$option])) {
                        $script      = $this->availableTests[$test_type]['options'][$option]['script'];
                        $script_path = "{$this->testDir}/scripts/{$test_type}/{$script}";

                        if (file_exists($script_path)) {
                            $scripts[$test_type][$option] = file_get_contents($script_path);
                        }
                    }
                }
            }
        }

        return $scripts;
    }

    public function generateJavascript($cron_config)
    {
        $scripts           = $this->getJavascripts();
        $generated_scripts = [];

        foreach ($scripts as $test_type => $options) {
            $total_options = count($options);

            if ($total_options) {
                $option_script = '';

                foreach ($options as $option => $script) {
                    $option_script .= "case '$option':\n";
                    $option_script .= "{$script}\n";
                    $option_script .= "break;\n";
                }
            }

            $script_names                  = implode("','", array_keys($options));
            $generated_scripts[$test_type] = <<<SCRIPT
                const {$test_type}_script_index = Math.floor(Math.random() * $total_options);
                const script_names = ['$script_names'];

                switch (script_names[{$test_type}_script_index]) {
                    {$option_script}
                }
SCRIPT;
        }

        $ab_test_options = '';

        if (isset($cron_config['ab_tests']) && count($generated_scripts)) {
            $ab_test_options = "const abTestOptions=" . json_encode($cron_config['ab_tests']) . ";";
        }

        return trim("\n" . $ab_test_options . "\n" . implode("\n", $generated_scripts));
    }
}