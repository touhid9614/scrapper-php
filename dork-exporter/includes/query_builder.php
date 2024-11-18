<?php
    
    /**
     * Gets the search queries.
     *
     * @return     array  The search queries.
     */
    function get_search_queries()
    {
        global $makes_file, $locality_file, $query_rules;
        
        $keywords['make']   = file($makes_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $keywords['city']   = file($locality_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        $queries = array();
        
        $keys_regex = '/\[(?<keys>[^\]]+)\]/';
        
        $matches = null;
        
        foreach ($query_rules as $query_rule)
        {
            if (preg_match_all($keys_regex, $query_rule, $matches))
            {
                $keys = $matches['keys'];
                
                $q = $query_rule;
                
                foreach ($keys as $key)
                {
                    $q = compile_query($q, $keywords, $key);
                }
                
                $queries = array_merge($queries, $q);
            }
            else
            {
                $queries[] = $query_rule;
            }
        }
        
        return $queries;
    }


    /**
     * { function_description }
     *
     * @param      array   $query     The query
     * @param      <type>  $keywords  The keywords
     * @param      <type>  $key       The key
     *
     * @return     array   ( description_of_the_return_value )
     */
    function compile_query($query, $keywords, $key)
    {
        if (!is_array($query)) 
        {
            $query = array($query);
        }
        
        if (!isset($keywords[$key])) 
        {
            return $query;
        }
        
        $result = array();
        
        foreach ($query as $q)
        {
            foreach ($keywords[$key] as $value)
            {
                $result[] = str_replace("[$key]", $value, $q);
            }
        }
        
        return $result;
    }


    /**
     * Loads dork queries.
     *
     * @param      string  $file   The file
     *
     * @return     array   ( description_of_the_return_value )
     */
    function load_dork_queries($file)
    {
        global $query_directory;
        
        $files = array();
        
        if ($file)
        {
            $file = "$query_directory/$file.txt";
            
            if (file_exists($file))
            {
                $files[] = $file;
            }
            else
            {
                $filename = basename($file);
                slecho("Unable to load query from your requested file <i>$filename</i>");

                return array();
            }
        }
        else
        {
            if (is_dir($query_directory))
            {
                foreach (array_filter(glob($query_directory . '/*.txt'), 'is_file') as $file)
                {
                    $files[] = $file;
                }
            }
        }
        
        $result = array();
        
        foreach ($files as $file)
        {
            $filename = basename($file);
            slecho("Loading query from: <i>$filename</i>");
            $queries = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $result = array_merge($result, $queries);
        }
        
        slecho('');
        
        return $result;
    }


    /**
     * Loads templated queries.
     *
     * @param      <type>  $query_rule  The query rule
     *
     * @return     array   ( description_of_the_return_value )
     */
    function load_templated_queries($query_rule)
    {
        global $makes_file, $locality_file, $dork_file, $autod_file;
        
        $keywords['make']   = file($makes_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $keywords['city']   = file($locality_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $keywords['dork']   = file($dork_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $keywords['dealer'] = file($autod_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        $queries = array();
        
        $keys_regex = '/\[(?<keys>[^\]]+)\]/';
        
        $matches = null;

        if (preg_match_all($keys_regex, $query_rule, $matches))
        {
            $keys = $matches['keys'];

            $q = $query_rule;

            foreach ($keys as $key)
            {
                $q = compile_query($q, $keywords, $key);
            }

            $queries = array_merge($queries, $q);
        }
        else
        {
            $queries[] = $query_rule;
        }
        
        return $queries;
    }
?>