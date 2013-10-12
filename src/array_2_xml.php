<?php

/** 
 * Convert array to XML
 * @license LGPL v3
 * @version 2013-10-04
 * @param $root string root node name
 * @param $array array array
 * @return XML
 */
function array_2_xml($root, $array)
{ 
    // Create document
    $document = new DOMDocument('1.0', 'utf-8');  
      
    // Create root node
    $root = $document->createElement($root);  
    $document->appendChild($root);
    
    // Create node function
    $createNode = function(DOMDocument $document, $key, $value)
                  use (&$createNode)
    {
        // Subnodes ?
        if (is_array($value)) {
            // Create node
            $node = $document->createElement($key);
            
            // Add subnodes
            foreach ($value as $subKey => $subValue) {
                if (is_int($subKey)) {
                    // Create subnode
                    $subNode = $createNode(
                        $document,
                        array_shift($subValue),
                        $subValue
                    );
                    
                    // Add subnode
                    $node->appendChild($subNode);
                } else if (substr($subKey, 0, 1) == '@') {  
                    // Add attribute
                    $node->setAttribute(substr($subKey, 1), $subValue);
                } else {  
                    // Create and add subnode
                    $node->appendChild(
                        $createNode($document, $subKey, $subValue)
                    );
                }  
            } 
            
            // Return node
            return $node;
        } else {
            // Create and return node
            return $document->createElement($key, $value);
        }
    };
      
    // Fill document
    foreach ($array as $key => $value) {
        if (is_int($key)) {
            // Create subnode
            $subNode = $createNode($document,array_shift($value),$value);
            
            // Add subnode
            $root->appendChild($subNode);
        } else if (substr($key, 0, 1) == '@') {
            // Add attribute
            $root->setAttribute(substr($key, 1), $value);
        } else {  
            // Create and add node
            $root->appendChild($createNode($document,$key,$value));  
        }  
    }  
      
    // Return XML
    return $document->saveXML();  
}