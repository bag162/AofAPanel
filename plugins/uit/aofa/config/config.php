<?php
use Uit\Aofa\Models\Settings;
$settings = Settings::instance();

use RainLab\Translate\Models\Message;



return [
    'payment_types' => [
        'balance' => 'С баланса',
        'pay' => 'Выполнить прямой перевод',
    ],
    'statuses' => [
        ['id' => 1, 'name' => 'В обработке', 'color' => '#3f51b5'],
        ['id' => 2, 'name' => 'Оплачено', 'color' => '#8bc34a'],
        ['id' => 3, 'name' => 'Исполняется', 'color' => 'orange'],
        ['id' => 4, 'name' => 'Успешно выполнен', 'color' => '#02a751'],
        ['id' => 5, 'name' => 'Отклонен', 'color' => 'red'],
    ],
    'types' => [
        [
            'id' => 1,
            'label' => 'Покупка аккаунтов',
            'component' => 'BuyAccount',
            'fields' => json_encode([
                [
                    'name' => 'country',
                    'rule' => 'required|in:Канада,США',
                    'label' => 'страна',
                ],
                [
                    'name' => 'account_count',
                    'rule' => 'required|numeric|min:'.$settings->get('min_buy_accounts',0),
                    'label' => 'кол-во аккаунтов',
                ],
                [
                    'name' => 'payment_type',
                    'rule' => 'required|in:balance,pay',
                    'label' => 'тип списания средств',
                ],
                [
                    'name' => 'payment_method',
                    'rule' => 'required_if:payment_type,pay',
                    'label' => 'тип выполненного перевода',
                ],             
                [
                    'name' => 'payment_date',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|date|date_format:Y-m-d\TH:i',
                    'label' => 'дата перевода',
                ],
                [
                    'name' => 'payment_sum',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|numeric',
                    'label' => 'сумма перевода',
                ],
                [
                    'name' => 'partner_code',
                    'rule' => 'required_if:payment_method,Партнёрский код',
                    'label' => 'партнёрский код',
                ],

                [
                    'name' => 'payment_check',
                    'rule' => 'max:5000',
                    'label' => 'чек, скриншот перевода',
                ],

                [
                    'name' => 'message',
                    'rule' => 'max:2000',
                    'label' => 'сообщение',
                ],
            ]),
        ],

        [
            'id' => 2,
            'label' => 'Восстановление аккаунтов',
            'component' => 'RestoreAccount',
            'fields' => json_encode([
                [
                    'name' => 'recover_file',
                    'rule' => 'required|max:10000',
                    'label' => 'файл с аккаунтами',
                ],
                [
                    'name' => 'account_count',
                    'rule' => 'required|numeric|min:'.$settings->get('min_restore_accounts',0),
                    'label' => 'кол-во аккаунтов',
                ],
                [
                    'name' => 'payment_type',
                    'rule' => 'required|in:balance,pay',
                    'label' => 'тип списания средств',
                ],
                [
                    'name' => 'payment_method',
                    'rule' => 'required_if:payment_type,pay',
                    'label' => 'тип выполненного перевода',
                ],
                [
                    'name' => 'payment_date',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|date|date_format:Y-m-d\TH:i',
                    'label' => 'дата перевода',
                ],
                [
                    'name' => 'payment_sum',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|numeric',
                    'label' => 'сумма перевода',
                ],
                [
                    'name' => 'partner_code',
                    'rule' => 'required_if:payment_method,Партнёрский код',
                    'label' => 'партнёрский код',
                ],
                [
                    'name' => 'payment_check',
                    'rule' => 'max:5000',
                    'label' => 'чек, скриншот перевода',
                ],
                [
                    'name' => 'message',
                    'rule' => 'max:2000',
                    'label' => 'сообщение',
                ],
            ]),
        ],
        [
            'id' => 3,
            'label' => 'Продление аренды ПО AofA SMS Service',
            'component' => 'RenewalArenda',
            'fields' => json_encode([
                [
                    'name' => 'license_count',
                    'rule' => 'required|numeric|min:1',
                    'label' => 'кол-во лицензий',
                ],
                [
                    'name' => 'month_count',
                    'rule' => 'required|numeric|min:1',
                    'label' => 'cрок продления',
                ],
                [
                    'name' => 'payment_type',
                    'rule' => 'required|in:balance,pay',
                    'label' => 'тип списания средств',
                ],
                [
                    'name' => 'payment_method',
                    'rule' => 'required_if:payment_type,pay',
                    'label' => 'тип выполненного перевода',
                ],
                [
                    'name' => 'payment_date',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|date|date_format:Y-m-d\TH:i',
                    'label' => 'дата перевода',
                ],
                [
                    'name' => 'payment_sum',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|numeric',
                    'label' => 'сумма перевода',
                ],
                [
                    'name' => 'partner_code',
                    'rule' => 'required_if:payment_method,Партнёрский код',
                    'label' => 'партнёрский код',
                ],
                [
                    'name' => 'payment_check',
                    'rule' => 'max:5000',
                    'label' => 'чек, скриншот перевода',
                ],
                [
                    'name' => 'message',
                    'rule' => 'max:2000',
                    'label' => 'сообщение',
                ],
            ]),
        ],
        [
            'id' => 4,
            'label' => 'Регистрация сессий',
            'component' => 'RegisterSession',
            'fields' => json_encode([
                [
                    'name' => 'recover_file',
                    'rule' => 'required|max:10000',
                    'label' => 'файл с аккаунтами',
                ],
                [
                    'name' => 'account_count',
                    'rule' => 'required|numeric|min:'.$settings->get('min_regsession_accounts',0),
                    'label' => 'кол-во аккаунтов',
                ],
                [
                    'name' => 'for_new_accounts',
                    'rule' => '',
                    'label' => 'для новых аккаунтов',
                ],
                [
                    'name' => 'payment_type',
                    'rule' => 'required|in:balance,pay',
                    'label' => 'тип списания средств',
                ],
                [
                    'name' => 'payment_method',
                    'rule' => 'required_if:payment_type,pay',
                    'label' => 'тип выполненного перевода',
                ],
                [
                    'name' => 'payment_date',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|date|date_format:Y-m-d\TH:i',
                    'label' => 'дата перевода',
                ],
                [
                    'name' => 'payment_sum',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|numeric',
                    'label' => 'сумма перевода',
                ],
                [
                    'name' => 'partner_code',
                    'rule' => 'required_if:payment_method,Партнёрский код',
                    'label' => 'партнёрский код',
                ],
                [
                    'name' => 'payment_check',
                    'rule' => 'max:5000',
                    'label' => 'чек, скриншот перевода',
                ],
                [
                    'name' => 'message',
                    'rule' => 'max:2000',
                    'label' => 'сообщение',
                ],
            ]),
        ],
        [
            'id' => 5,
            'label' => 'Пополнение баланса личного кабинета',
            'component' => 'AddBalance',
            'fields' => json_encode([
               
                [
                    'name' => 'payment_method',
                    'rule' => 'required',
                    'label' => 'тип выполненного перевода',
                ],
                [
                    'name' => 'payment_date',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|date|date_format:Y-m-d\TH:i',
                    'label' => 'дата перевода',
                ],
                [
                    'name' => 'payment_sum',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|numeric',
                    'label' => 'сумма перевода',
                ],
                [
                    'name' => 'partner_code',
                    'rule' => 'required_if:payment_method,Партнёрский код',
                    'label' => 'партнёрский код',
                ],
                [
                    'name' => 'payment_check',
                    'rule' => 'max:5000',
                    'label' => 'чек, скриншот перевода',
                ],
                [
                    'name' => 'message',
                    'rule' => 'max:2000',
                    'label' => 'сообщение',
                ],
            ]),
        ],
        [
            'id' => 6,
            'label' => 'Администрирование серверов',
            'component' => 'AdminServer',
            'fields' => json_encode([
                [
                    'name' => 'admin_server',
                    'rule' => 'required|in:tnmanager,smsservice',
                    'label' => 'тип администрируемого ПО',
                ],
                [
                    'name' => 'server_count',
                    'rule' => 'required|numeric|min:1',
                    'label' => 'кол-во серверов',
                ],
                [
                    'name' => 'week_count',
                    'rule' => 'required|numeric|min:1',
                    'label' => 'срок продления',
                ],
                [
                    'name' => 'payment_type',
                    'rule' => 'required|in:balance,pay',
                    'label' => 'тип списания средств',
                ],
                [
                    'name' => 'payment_method',
                    'rule' => 'required_if:payment_type,pay',
                    'label' => 'тип выполненного перевода',
                ],
                [
                    'name' => 'payment_date',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|date|date_format:Y-m-d\TH:i',
                    'label' => 'дата перевода',
                ],
                [
                    'name' => 'payment_sum',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|numeric',
                    'label' => 'сумма перевода',
                ],
                [
                    'name' => 'partner_code',
                    'rule' => 'required_if:payment_method,Партнёрский код',
                    'label' => 'партнёрский код',
                ],
                [
                    'name' => 'payment_check',
                    'rule' => 'max:5000',
                    'label' => 'чек, скриншот перевода',
                ],
                [
                    'name' => 'message',
                    'rule' => 'max:2000',
                    'label' => 'сообщение',
                ],
            ]),
        ],
        [
            'id' => 7,
            'label' => 'Покупка ПО AofA SMS Service',
            'component' => 'BuyService',
            'fields' => json_encode([
                [
                    'name' => 'name',
                    'rule' => 'required',
                    'label' => 'имя',
                ],
                [
                    'name' => 'phone',
                    'rule' => 'required',
                    'label' => 'telegram',
                ],
                [
                    'name' => 'email',
                    'rule' => 'required|email',
                    'label' => 'почта',
                ],
                [
                    'name' => 'payment_method',
                    'rule' => 'required',
                    'label' => 'тип выполненного перевода',
                ],
                [
                    'name' => 'payment_date',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|date|date_format:Y-m-d\TH:i',
                    'label' => 'дата перевода',
                ],
                [
                    'name' => 'payment_sum',
                    'rule' => 'required_if:payment_method,Банковская карта|required_if:payment_method,Qiwi|required_if:payment_method,WebMoney|numeric',
                    'label' => 'сумма перевода',
                ],
                [
                    'name' => 'partner_code',
                    'rule' => 'required_if:payment_method,Партнёрский код',
                    'label' => 'партнёрский код',
                ],
                [
                    'name' => 'payment_check',
                    'rule' => 'max:5000',
                    'label' => 'чек, скриншот перевода',
                ],
            ]),
        ],
    ],
];
