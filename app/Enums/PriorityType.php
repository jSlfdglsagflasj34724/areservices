<?php
  
namespace App\Enums;
 
enum PriorityType:string {
    case NORMAL = 'normal';
    case CRITICAL = 'critical';
}
