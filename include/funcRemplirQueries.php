<?php
    function RemplirQueries(){
        $queries = '?';
        $nb_queries = func_num_args();
        for ($i = 0; $i < $nb_queries; $i++){
            [$cle, $valeur] = func_get_arg($i);
            $valeur = str_replace(' ', '+', $valeur);
            $queries .= "$cle=$valeur";

            if($i < $nb_queries -1)
                $queries .= '&';
        }
        return $queries;
    }