<?php
  
namespace App\Enums;
 
enum JobStatus:string {
    case OPEN = 'open';
    case RESCHEDULE = 'reschedule';
    case SCHEDULE = 'scheduled';
    case INPROGRESS = 'in-progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
