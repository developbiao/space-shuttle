<?php
class RequestHelper {

}

abstract class ProcessRequest {
  abstract function process( RequestHelper $req);

}

class MainProcess extends ProcessRequest
{
  public function process(RequestHelper $req)
  {
    print __CLASS__ . ": doing somethig useful with request\n";

  }

}

abstract class DecorateProcess extends ProcessRequest
{
  protected $process_request;

  public function __construct(ProcessRequest $process_request)
  {
    $this->process_request = $process_request;
  }

}

class LogRequest extends DecorateProcess
{
  public function process(RequestHelper $req)
  {
    print __CLASS__ . ": logging request\n";
    $this->process_request->process( $req );
  }

}

class AuthenticateRequest extends DecorateProcess
{
  public function process(RequestHelper $req)
  {
    print __CLASS__ . ": authenticating request\n";
    $this->process_request->process( $req );

  }

}

class StructureRequest extends DecorateProcess
{
  public function process(RequestHelper $req)
  {
    print __CLASS__ . ": structure request\n";
    $this->process_request->process( $req );
  }

}

$process = new AuthenticateRequest(new StructureRequest(
           new LogRequest(
           new MainProcess()
            )
      )
    );

$process->process( new RequestHelper() );

?>
