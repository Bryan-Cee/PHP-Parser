<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 2019-03-12
 * Time: 16:40
 * @property array|null doubles
 */

class ParseArgv {
    // the original arguments passed in from the command line
    private $cli_args = [];
    // all of the arguments joined into a single string with the path removed
    private $cli_string_input = null;

    private $singlesArgs = null;
    private $doublesArgs = null;
    private $flags = null;

    public function __construct($cli_input) {
        $this->cli_args = $cli_input;
        $this->cli_string_input = join(' ', array_slice($cli_input, 1));

        $this->parse();
    }

    private function parse() {
        $this->singlesArgs = [];
        $this->doublesArgs = [];
        $this->flags = [];

        // regex to find all of the single dash arguments with flags
        preg_match_all("/(?:^|\s)-(\w+ )(?:([^-]*\b))?\b/", $this->cli_string_input, $singleDashArgs, PREG_SET_ORDER);
        // regex to find all of the double dash arguments
        preg_match_all("/(?:^|\s)--([a-zA-Z0-9_]+)=([^-]*)\b/", $this->cli_string_input, $doubleDashArgs, PREG_SET_ORDER);

        preg_match_all("/(?:^|\s)-[a-zA-Z](\s|)(?![^-])/", $this->cli_string_input, $flagsArgs, PREG_SET_ORDER);
        //parse single dash arguments with flags
        $singlesArgsTemp = [];
        foreach ($singleDashArgs as $arg) {
            array_push($singlesArgsTemp,trim($arg[0]));
        }
        unset($arg);
        foreach ($singlesArgsTemp as $item) {
            $item = explode(' ', $item);
            $item[0] = preg_replace("/-/","",$item[0]);
            $item[1] = str_replace(',',' ', $item[1]);
            array_push($this->singlesArgs, $item);
        }
        unset($item);

        //parse double dash arguments with flags
        $doublesArgsTemp = [];
        foreach ($doubleDashArgs as $arg) {
            array_push($doublesArgsTemp,trim($arg[0]));
        }
        unset($arg);
        foreach ($doublesArgsTemp as $item) {
            $item = explode('=', $item);
            $item[0] = preg_replace("/-/","",$item[0]);
            $item[1] = str_replace(',',' ', $item[1]);
            array_push($this->doublesArgs, $item);
        }
        unset($item);
        //parse single dash arguments without flags
        $flagsArgsTemp = [];
        foreach ($flagsArgs as $arg) {
            array_push($flagsArgsTemp,trim($arg[0]));
        }
        foreach ($flagsArgsTemp as $item) {
            $item = preg_replace("/-/","",$item);
            array_push($this->flags, $item);
        }
        unset($arg);

    }

    public function __get($name) {
        if ($name === 'singles') {
            return $this->singlesArgs;
        } elseif ($name === 'double') {
            return $this->doublesArgs;
        } elseif ($name === 'flags') {
            return $this->flags;
        }
        return null;
    }
}

