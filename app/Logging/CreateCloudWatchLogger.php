<?php

namespace App\Logging;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use PhpNexus\Cwh\Handler\CloudWatch;
use Monolog\Formatter\JsonFormatter;
use Monolog\Level;
use Monolog\Logger;

class CreateCloudWatchLogger
{
    public function __invoke(array $config): Logger
    {
        $client = new CloudWatchLogsClient([
            'region'      => $config['region'],
            'version'     => 'latest',
            'credentials' => [
                'key'    => $config['key'] ?? null,
                'secret' => $config['secret'] ?? null,
            ],
        ]);

        $group  = $config['group'];               // e.g. /app/laravel/prod
        $stream = $config['stream'];              // e.g. web-{{hostname}}
        $retention = $config['retention'] ?? null;  // days; 1095 = ~3 years
        $tags = $config['tags'] ?? [];            // optional key/value tags

        $handler = new CloudWatch(
            $client,
            $group,
            $stream,
            $retention,
            $config['batch_size'] ?? 10000,
            $tags,
            $config['level'] ?? Level::Info,
            $config['bubble'] ?? true
        );

        // JSON logs = easier searching in CloudWatch Logs Insights
        $handler->setFormatter(new JsonFormatter());

        $logger = new Logger($config['name'] ?? 'cloudwatch');
        $logger->pushHandler($handler);

        return $logger;
    }
}
