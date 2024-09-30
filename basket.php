<?php
const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];


do {
//    system('clear');
    $operationNumber = getOperationNumber($items, $operations);
    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addGoods($items);
            break;

        case OPERATION_DELETE:
            deleteGoods($items);
            break;

        case OPERATION_PRINT:
            printListOfGoods($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;


/**
 * Echoes the list of goods or message, that nothing found
 * @param array $items array of items
 * @param array $operations array of possible operations
 * @return int returns the operation number of user selection
 */
function getOperationNumber(array $items, array $operations): int {
    system('cls'); // windows

    do {
        if (count($items)) {
            getListOfGoods($items);
        } else {
            echo 'Ваш список покупок пуст.' . PHP_EOL;
        }


        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        for ($i = 0; $i < count($operations); $i++) {
            if (count($items) === 0 && $i === 2) {
                continue;
            } else {
                echo $operations[$i] . PHP_EOL;
            }
        }
        $operationNumber = trim(fgets(STDIN));

        if (!array_key_exists($operationNumber, $operations)) {
            system('cls');

            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }

    } while (!array_key_exists($operationNumber, $operations));
    return $operationNumber;
}

/**
 * Echoes cuurent list of goods
 * @param array $items
 * @return void
 */
function getListOfGoods(array $items): void {
    echo 'Ваш список покупок: ' . PHP_EOL;
    echo implode("\n", $items) . "\n";
}


/**
 * Request and add goods to the list of $items
 * @param array $items array of items
 * @return void
 */
function addGoods(array &$items): void {
    echo "Введение название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
}

/**
 * Delete selected items from the $items list. Selecttion determines by user enter
 * @param array $items array of items
 * @return void
 */
function deleteGoods(array &$items): void {
    if (count($items) === 0) {
        echo 'В списке покупок пока нет товаров. Попробуйте сначала добавить.' . PHP_EOL . '> ';
    } else {
        getListOfGoods($items);

        echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
        $itemName = trim(fgets(STDIN));

        if (in_array($itemName, $items, true) !== false) {
            while (($key = array_search($itemName, $items, true)) !== false) {
                unset($items[$key]);
            }
        }
    }
    
}

/**
 * Printing out the current list of goods
 * @param array $items array of items
 * @return void
 */
function printListOfGoods(array $items): void {
    getListOfGoods($items);
    echo 'Всего ' . count($items) . ' позиций. '. PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}