<?php
namespace FileTools;

class ErrorMsg{

    private array $messages;
    private string $prefixMessage;

    public function __construct(string $prefixMsg = "")
    {
        $this->messages = [];
        $this->prefixMessage = $prefixMsg;
    }

    public function setPrefixMessage(string $prefixMsg){
        $this->prefixMessage = $prefixMsg;
    }

    public function getPrefixMessage():string {
        return $this->prefixMessage;
    }

    public function hasError():bool {
        return $this->getNumberMessage() > 0;
    }

    public function getNumberMessage():int {
        return count($this->messages);
    }

    public function addMsg(string $msg):ErrorMsg{
        $this->messages[] = $this->prefixMessage . $msg;
        return $this;
    }

    public function getAllMsg():array {
        return $this->messages;
    }

    public function showAllMessage($resetMsg = true):ErrorMsg {
        foreach ($this->messages as $message){
           $this->showMessage($message);
        }

        if($resetMsg){
            $this->clearMessages();
        }

        return $this;
    }

    public function clearMessages(){
        $this->messages = [];
    }

    public function showMessage(string $msg):void {
        echo $msg . PHP_EOL;
    }

    public function getAllMessage():array {
        return $this->messages;
    }
}
