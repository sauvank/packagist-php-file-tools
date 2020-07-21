<?php
namespace FileTools;

use League\CLImate\CLImate;

class LogCli{

    private CLImate $climate;

    public function __construct()
    {
        $this->climate = new CLImate();
    }

    public function info(string $title, string $msg){
        $this->climate
            ->darkGray(PHP_EOL . $title)
            ->lightGray('     - ' . $msg);
    }

    /**
     * @param string|array $msg
     */
    public function warning($msg){
        $this->climate
            ->yellow(PHP_EOL . '======================')
            ->yellow('Warning : ');

        if(gettype($msg) === 'string'){
            $this->climate->whisper($msg);
        }else{
            foreach ($msg as $v){
                $this->climate->whisper($v);
            }
        }

        $this->climate
            ->yellow('======================');
    }
}
