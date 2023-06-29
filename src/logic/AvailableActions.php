<?php
namespace taskforce\logic;
class AvailableActions
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'proceed';
    const STATUS_CANCEL = 'cancel';
    const STATUS_COMPLETE = 'complete';
    const STATUS_EXPIRED = 'expired';

    const ACTION_RESPONSE = 'act_response';
    const ACTION_CANCEL = 'act_cancel';
    const ACTION_DENY = 'act_deny';
    const ACTION_COMPLETE = 'act_complete';

    private int $clientId;
    private ?int $performerId;
    private string $status;

    /**
     * @param string $status
     * @param int $clientId
     * @param int|null $performerId
     */
    public function __construct (string $status, int $clientId, ?int $performerId = null)
    {
        $this->status = $status;
        $this->clientId = $clientId;
        $this->performerId = $performerId;
    }

    /**
     * @return string[]
     */
    public function getStatusMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::ACTION_CANCEL => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::ACTION_COMPLETE => 'Выполнено',
            self::STATUS_EXPIRED => 'Провалено',
        ];
    }

    /**
     * @return string[]
     */
    public function getActionsMap(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPONSE => 'Откликнуться',
            self::ACTION_COMPLETE => 'Выполнено',
            self::ACTION_DENY => 'Отказаться',

        ];
    }

    /**
     * @param string $action
     * @return string|null
     */
    public function getNextStatus(string $action)
    {
        $map = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETE,
            self::ACTION_CANCEL => self::STATUS_CANCEL,
            self::ACTION_DENY => self::STATUS_CANCEL,
        ];

        return $map[$action] ?? null;
    }

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $availableStatuses = [
          self::STATUS_NEW,
          self::STATUS_CANCEL,
          self::STATUS_COMPLETE,
          self::STATUS_EXPIRED,
          self::STATUS_IN_PROGRESS,
        ];

        if (in_array($status, $availableStatuses)) {
            $this->status = $availableStatuses[$status];
        }
    }

    public function statusAllowedActions(string $status): array
    {
        $map = [
            self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPONSE],
            self::STATUS_IN_PROGRESS => [self::ACTION_DENY, self::ACTION_COMPLETE],
        ];

        return $map[$status] ?? [];
    }
}