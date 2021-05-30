<?php


namespace App\Util;


class PathHelper
{
    const HTTP = 'http';
    const HTTPS = 'https';
    const PARENT_DIR = '..';

    public static function getHost()
    {
        $protocol = self::HTTP;
        $serverName = $_SERVER['SERVER_NAME'];
        $port = $_SERVER['SERVER_PORT']; //on env(PROD) port will be 80?
        if (strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 4)) !== self::HTTP) {
            $protocol = self::HTTPS;
        }
        return sprintf("%s://%s%s", $protocol ,  $serverName ,  ($port === "80" ? '' : ":" . $port));
    }

    public static function getFileExtensionFromPath(string $filepath)
    {
        if (strpos($filepath, '.') != false) {
            $splitValue = explode('.', $filepath);
            return end($splitValue);
        }
        return '';
    }

    /**
     * @param string $projectDir
     * @return string
     */
    public static function getPublicDir(string $projectDir)
    {
        return $projectDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . (getenv('APP_ENV') === 'dev' ? 'public' : 'build') . DIRECTORY_SEPARATOR;
    }

    /**
     * Generates unique filename based on current time
     * @param string|null $prefix
     * @return string
     */
    public static function generateFilename(string $prefix = null)
    {
        return sprintf('%s-%s-%s', $prefix, (new \DateTime())->format('YmdHis'), uniqid());
    }
}