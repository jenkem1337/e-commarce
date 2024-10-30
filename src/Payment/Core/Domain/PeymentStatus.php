<?php
enum PeymentStatus: string {
    case Pending = "Pending";
    case Completed = "Completed";
    case Failed = "Failed";
    case Refunded  = "Refunded";
}