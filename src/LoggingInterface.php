<?php

namespace Acheron;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\ErrorHandler;
use Monolog\Formatter\LineFormatter;
use Bramus\Monolog\Formatter\ColoredLineFormatter;

/* we have two logs, the "full" log, and the "narrative" log (which is more
meant to give a sort of narrative view of what happened system-wise during
the game)
*/

class LoggingInterface
{
    public string $dateformat = "Y-m-d H:i:s";
    public string $output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
    public Logger $server;
    public Logger $narrative;

    public function __construct()
    {
        $this->server = new Logger('acheron_API_full');
        $handler = new StreamHandler(__DIR__ . '../logs/server.log', Level::Debug);
        $handler->setFormatter(new ColoredLineFormatter(null, $this->output, $this->dateFormat));
        $this->server->pushHandler($handler);
        ErrorHandler::register($this->server); // log all errors and exceptions to the logfile

        $this->narrative = new Logger('acheron_narrative');
        $handlerNarrative = new StreamHandler(__DIR__ . '../logs/narrative.log', Level::Debug);
        $handlerNarrative->setFormatter(new ColoredLineFormatter(null, $this->output, $this->dateFormat));
        $this->narrative->pushHandler($handlerNarrative);
    }
}
