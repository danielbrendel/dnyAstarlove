<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PushModel;
use App\Models\MailerModel;

/**
 * Class MessageModel
 *
 * Interface to private messages
 */
class MessageModel extends Model
{
    use HasFactory;

    /**
     * Add message
     *
     * @param $userId
     * @param $senderId
     * @param $subject
     * @param $message
     * @return mixed
     * @throws \Exception
     */
    public static function add($userId, $senderId, $subject, $message)
    {
        try {
            $user = User::where('id', '=', $userId)->first();
            if (!$user) {
                throw new \Exception('User not found: ' . $userId);
            }

            $sender = User::where('id', '=', $senderId)->first();
            if (!$sender) {
                throw new \Exception('Sender not found: ' . $senderId);
            }

            $channel = static::select('channel')->where('userId', '=', $userId)->where('senderId', '=', $senderId)->first();
            if (!$channel) {
                $channel = static::select('channel')->where('senderId', '=', $userId)->where('userId', '=', $senderId)->first();
                if (!$channel) {
                    $channel = md5(strval($userId) . strval($senderId) . random_bytes(55));
                } else {
                    $channel = $channel->channel;
                }
            } else {
                $channel = $channel->channel;
            }

            $msg = new self();
            $msg->userId = $userId;
            $msg->senderId = $senderId;
            $msg->channel = $channel;
            $msg->subject = $subject;
            $msg->message = \Purifier::clean($message);
            $msg->save();

            PushModel::addNotification(__('app.new_message_short', ['name' => $sender->username]), __('app.new_message', ['name' => $sender->username, 'subject' => $subject]), 'PUSH_MESSAGED', $userId);

            if ($user->email_on_message) {
                $html = view('mail.message', ['name' => $user->username, 'sender' => $sender->username, 'message' => $message, 'msgid' => $msg->id])->render();
                MailerModel::sendMail($user->email, __('app.message_received'), $html);
            }

            return $msg->id;
        } catch (\Exception $e) {
            throw $e;
        }

        return 0;
    }

    /**
     * Fetch message pack
     *
     * @param $userId
     * @param $limit
     * @param null $paginate
     * @return mixed
     * @throws \Exception
     */
    public static function fetch($userId, $limit, $paginate = null)
    {
        try {
            $rowset = static::where('userId', '=', $userId)->orWhere('senderId', '=', $userId);

            if ($paginate !== null) {
                $rowset->where('id', '<', $paginate);
            }

            return $rowset->orderBy('id', 'desc')->limit($limit)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get message thread
     *
     * @param $msgId
     * @return array
     * @throws \Exception
     */
    public static function getMessageThread($msgId)
    {
        try {
            $msg = static::where('id', '=', $msgId)->first();
            if (!$msg) {
                throw new \Exception('Message not found: ' . $msgId);
            }

            $msg->seen = true;
            $msg->save();

            $previous = static::where(function($query) use ($msg) {
                $query->where('userId', '=', $msg->userId)
                    ->where('senderId', '=', $msg->senderId)
                    ->where('id', '<>', $msg->id);
            })->orWhere(function($query) use ($msg) {
                $query->where('userId', '=', $msg->senderId)
                    ->where('senderId', '=', $msg->userId);
            })->orderBy('created_at', 'desc')->get();
            foreach ($previous as $item) {
                if (!$item->seen) {
                    $item->seen = true;
                    $item->save();
                }
            }

            return array(
              'msg' => $msg,
              'previous' => $previous
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get amount of unread messages
     *
     * @param $userId
     * @return int
     * @throws \Exception
     */
    public static function unreadCount($userId)
    {
        try {
            return static::where('userId', '=', $userId)->where('seen', '=', false)->count();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
