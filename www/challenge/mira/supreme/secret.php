<?php
/**
 * This belongs into phpgdo-linkuup module as unstaged hidden blob.
namespace GDO\LinkUUp\Websocket;
use GDO\LinkUUp\LUPWS_Command;
use GDO\Util\WS;
use GDO\Websocket\Server\GWS_Commands;
use GDO\Websocket\Server\GWS_Message;
final class LUPWS_WeChall extends LUPWS_Command
{
    private const HASH_PREFIX = '404695397315a771';  (md5(OBFUSCATED)[0:16])
    public function execute(GWS_Message $msg): void
    {
        $guess = strtolower(trim($msg->readString()));
        $matched = '';
        if (preg_match('/^[0-9a-f]*$/D', $guess))
        {
            $length = min(strlen($guess), strlen(self::HASH_PREFIX));
            for ($i = 0; $i < $length; $i++)
            {
                if ($guess[$i] !== self::HASH_PREFIX[$i])
                {
                    break;
                }
                $matched .= $guess[$i];
            }
        }
        $reply = $matched;
        if ($matched === self::HASH_PREFIX)
        {
            $reply .= "\nCongrats, my hacker.";
        }
        $msg->replyBinary($msg->cmd(), WS::wrString($reply));
    }
}
GWS_Commands::register(0x1337, new LUPWS_WeChall());
 */
return 'OBFUSCATED';
