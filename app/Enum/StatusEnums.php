<?php

namespace App\Enum;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
    case VIEWED = 'viewed';
    case PAID = 'paid';
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';
    case PARTIALLY_REFUNDED = 'partially_refunded';
    case PARTIALLY_PAID = 'partially_paid';
    case OVERDUE = 'overdue';
    case VOID = 'void';
    case COMPLETED = 'completed';
    case IN_PROGRESS = 'in_progress';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case PENDING = 'pending';
    case EXPIRED = 'expired';
    case PROCESSING = 'processing';
    case ON_HOLD = 'on_hold';
    case FAILED = 'failed';
    case OPEN = 'open';
    case CLOSED = 'closed';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case LOCKED = 'locked';
    case UNLOCKED = 'unlocked';
    case SIGNED = 'signed';
    case UNSIGNED = 'unsigned';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => __('pdf.statuses.draft'),
            self::SENT => __('pdf.statuses.sent'),
            self::VIEWED => __('pdf.statuses.viewed'),
            self::PAID => __('pdf.statuses.paid'),
            self::CANCELED => __('pdf.statuses.canceled'),
            self::REFUNDED => __('pdf.statuses.refunded'),
            self::PARTIALLY_REFUNDED => __('pdf.statuses.partially_refunded'),
            self::PARTIALLY_PAID => __('pdf.statuses.partially_paid'),
            self::OVERDUE => __('pdf.statuses.overdue'),
            self::VOID => __('pdf.statuses.void'),
            self::COMPLETED => __('pdf.statuses.completed'),
            self::IN_PROGRESS => __('pdf.statuses.in_progress'),
            self::ACCEPTED => __('pdf.statuses.accepted'),
            self::REJECTED => __('pdf.statuses.rejected'),
            self::PENDING => __('pdf.statuses.pending'),
            self::EXPIRED => __('pdf.statuses.expired'),
            self::PROCESSING => __('pdf.statuses.processing'),
            self::ON_HOLD => __('pdf.statuses.on_hold'),
            self::FAILED => __('pdf.statuses.failed'),
            self::OPEN => __('pdf.statuses.open'),
            self::CLOSED => __('pdf.statuses.closed'),
            self::ACTIVE => __('pdf.statuses.active'),
            self::INACTIVE => __('pdf.statuses.inactive'),
            self::LOCKED => __('pdf.statuses.locked'),
            self::UNLOCKED => __('pdf.statuses.unlocked'),
            self::SIGNED => __('pdf.statuses.signed'),
            self::UNSIGNED => __('pdf.statuses.unsigned'),
        };
    }
}
