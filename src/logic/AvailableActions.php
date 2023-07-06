<?php
namespace taskforce\logic;

use taskforce\logic\actions\CancelAction;
use taskforce\logic\actions\ResponseAction;
use taskforce\logic\actions\DenyAction;
use taskforce\logic\actions\CompleteAction;
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

    const ROLE_CLIENT = 'client';
    CONST ROLE_PERFORMER = 'performer';

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

    public function getAvailableActions(string $role, int $id)
    {
        $statusActions = $this->statusAllowedActions($this->status);
        $roleActions = $this->roleAllowedActions($role);

        $allowedActions = array_intersect($statusActions, $roleActions);

        $allowedActions = array_filter($allowedActions, function ($action) use ($id) {
            return $action::checkRights($id, $this->clientId, $this->performerId);
        });

        return array_values($allowedActions);
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
            CompleteAction::class => self::STATUS_COMPLETE,
            CancelAction::class => self::STATUS_CANCEL,
            DenyAction::class => self::STATUS_CANCEL,
            ResponseAction::class => null,
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

    /**
     * Возвращает действия доступные для каждого статуса
     * @param string $status
     * @return array|string[]
     */
    private function statusAllowedActions(string $status): array
    {
        $map = [
            self::STATUS_NEW => [CancelAction::class, ResponseAction::class],
            self::STATUS_IN_PROGRESS => [DenyAction::class, CompleteAction::class],
        ];

        return $map[$status] ?? [];
    }

    /**
     * Возвращает действия доступные для каждой роли
     * @return array[]
     */
    private function roleAllowedActions(string $role): array
    {
        $map = [
            self::ROLE_CLIENT => [CancelAction::class, CompleteAction::class],
            self::ROLE_PERFORMER => [DenyAction::class, ResponseAction::class],
        ];

        return $map[$role];
    }

}