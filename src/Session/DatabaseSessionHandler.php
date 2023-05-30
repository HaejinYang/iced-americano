<?php
namespace Thumbsupcat\IcedAmericano\Session;

use Thumbsupcat\IcedAmericano\Database\Adaptor;

class DatabaseSessionHandler implements \SessionHandlerInterface
{
    public function open(string $path, string $name): bool
    {
       return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read(string $id): string|false
    {
        $data = current(Adaptor::getAll("SELECT * FROM session WHERE `id` = ?", [$id]));
        if($data) {
            $payload = $data->payload;
        } else {
            Adaptor::exec("INSERT INTO session(`id`) VALUES(?)", [$id]);
        }

        return $payload ?? '';
    }

    public function destroy(string $id): bool
    {
        return Adaptor::exec('DELETE FROM session WHERE `id` = ?', [$id]);
    }

    public function gc(int $max_lifetime): int|false
    {
        if($sessions = Adaptor::getAll('SELECT * FROM session')) {
            foreach ($sessions as $session) {
                $timestamp = strtotime($session->created_at);
                if(time() - $timestamp > $max_lifetime) {
                    $this->destroy($session->id);
                }
            }

            return true;
        }

        return false;
    }

    public function write(string $id, string $data): bool
    {
        return Adaptor::exec("UPDATE session SET `payload` = ? WHERE `id` = ?", [$data, $id]);
    }
}