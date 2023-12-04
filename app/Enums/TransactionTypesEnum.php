<?php

namespace App\Enums;

enum TransactionTypesEnum: int {
    case TRANSFER = 1;
    case PIX = 2;
    case LOAN = 3;
    case SAVINGS = 4;
}
