<?php
    class ParseSuccess{
        public $expr;
        public $message;

        function __construct($expr, $message){
            $this->expr = $expr;
            $this->message = $message;
        }

        function getXML(){
            return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
                   "\n<success>" .
                   "\n    <expression>" . encode($this->expr) . "</expression>" .
                   "\n    <message>" . encode($this->message) . "</message>" .
                   "\n</success>";
        }
    }

    class ParseError{
        public $expr;
        public $message;
        public $pos;
        public $token;

        function __construct($expr, $message, $pos, $token){
            $this->expr = $expr;
            $this->message = $message;
            $this->pos = $pos;
            $this->token = $token;
        }

        function getXML(){
            return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
                   "\n<error pos=\"" . $this->pos . "\" found=\"" . encode($this->token) . "\">" .
                   "\n    <expression>" . encode($this->expr) . "</expression>" .
                   "\n    <message>" . encode($this->message) . "</message>" .
                   "\n</error>";
        }
    }

    class AutocompleteResult{
        public $expr;
        public $pos;
        public $token;
        private $expectedByType;

        function __construct($expr, $pos, $token){
            $this->expr = $expr;
            $this->pos = $pos;
            $this->token = $token;
        }

        function addExpected($type, $matches){
            $vals = $this->expectedByType[$type];
            if ($vals === null){
                $this->expectedByType[$type] = $matches;
            }
            else{
                // TODO add rather than copy over the existing values
                $this->expectedByType[$type] = $matches;
            }
        }

        function getXML(){
            $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
                   "\n<results pos=\"" . $this->pos . "\" found=\"" . encode($this->token) . "\">" .
                   "\n    <expression>" . encode($this->expr) . "</expression>";

            foreach ($this->expectedByType as $type => $matches){
                $xml .= "\n    <expected type=\"" . $type . "\">";
                foreach ($matches as $match){
                    $xml .= "\n        <token>$match</token>";
                }
                $xml .= "\n    </expected>";
            }

            $xml .= "\n</results>";
            return $xml;
        }
    }

    function encode($str){
        return $str;
    }
?>