<?php
$sql_files = ['create-bka-users-table.sql',
            'create-bka-user-details-table.sql',
            'create-clients-table.sql',
            'create-coaches-table.sql',
            'create-sessions-table.sql',
            'create-questions-table.sql',
            'create-question-translations-table.sql'
        ];

        
        parsVariables('./includes/databases/create-bka-user-details-table.sql');  

        

        

        function parsVariables($file_path) {
            $new_content = '';
            $file_content = file_get_contents($file_path);
            if ($file_content) {
                $lines = explode("\n", $file_content);
                foreach ($lines as $line) {
                    preg_match_all('/\{(.*?)\}/', $line, $matches);
                    foreach ($matches[1] as $match) {
                        if (! isset($$match)) {
                           error_log('Variable ' . $match . ' not set');
                            continue;                     
                        }                        
                        $variables[] = $match;
                        $line= str_replace('{' . $match . '}', $$match, $line);                 
                        
                    }
                    $new_content .= $line . "\n";
                }
            }
                
            return $new_content;
        }