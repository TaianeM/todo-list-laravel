<?php

namespace App\Enums;
 
enum TaskStatus:string {
    case PENDING = 'pending';
    case PROGRESS = 'progress';
    case COMPLETED = 'completed';
}
