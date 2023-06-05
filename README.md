<a name="cryptopro-php"></a>
# КриптоПРО PHP SDK
PHP SDK для работы с API расширения КриптоПро (`libphpcades`), аналогичный КриптоПро ЭЦП Browser plug-in

- [КриптоПРО PHP SDK](#cryptopro-php)
    - [Зачем нужен этот пакет?](#why)
    - [Установка](#install)
    - [API](#api)
        - [Методы класса CryptoPro](#api-cryptopro)
        - [Методы объекта сертификата](#api-certificate)
    - [Поддерживаемые СКЗИ](#supported-cist)
    - [Примеры](#examples)
        - [Тэг script (UMD)](#example-script-tag)
- [Тем, кто хочет помочь](#developers)
    - [Запуск режима разработки](#dev-mode)
    - [Запуск тестов](#tests-execution)
    - [Проверка пакета перед публикацией в NPM](#final-check)
- [Лицензия](#lisense)


<a name="why"></a>
## Зачем нужен этот пакет?
Этот паект призван упроостить взаимодействие с абсолютно не документированным [расширением КриптоПро для PHP](https://docs.cryptopro.ru/cades/phpcades).
Пакет реализует упрощённый доступ к следующим операциям:
- работа с сертификатами;
- создание и проверка подписи;
- шифрование и расшифрование данных.

Немаловажным фактором, в выборе этого пакета, является полное соответсвие набора методов, с [КриптоПРО JS SDK](https://github.com/webmasterskaya/crypto-pro-js)

<a name="install"></a>
## Установка

Установка осуществляется через [Composer](https://getcomposer.org/). 
```shell
composer require webmasterskaya/crypto-pro-php
```

<a name="api"></a>
## API

<a name="api-cryptopro"></a>
### Методы класса СryptoPro
- [СryptoPro::getUserCertificates()](docs/api/CryptoPro/getUserCertificates.md) - возвращает список сертификатов, доступных пользователю в системе
- [СryptoPro::getAllUserCertificates()](docs/api/CryptoPro/getAllUserCertificates.md) - возвращает список всех сертификатов, доступных пользователю в системе, в том числе, просроченные и без закрытого ключа
- [СryptoPro::getContainerCertificates()](docs/api/CryptoPro/getContainerCertificates.md) - возвращает список сертификатов, из закрытых ключей и/или сертификаты не установленные всистеме*
- [СryptoPro::getAllContainerCertificates()](docs/api/CryptoPro/getAllContainerCertificates.md) - возвращает список всех сертификатов, из закрытых ключей и/или сертификаты не установленные всистеме*, в том числе, просроченные и без закрытого ключа
- [СryptoPro::getCertificate()](docs/api/CryptoPro/getCertificate.md) - возвращает сертификат по отпечатку
- [СryptoPro::createAttachedSignature()](docs/api/CryptoPro/createAttachedSignature.md) - создает совмещенную (присоединенную) подпись сообщения
- [СryptoPro::createDetachedSignature()](docs/api/CryptoPro/createDetachedSignature.md) - создает отсоединенную (открепленную) подпись сообщения
- [СryptoPro::addAttachedSignature()](docs/api/CryptoPro/addAttachedSignature.md) - добавляет совмещенную (присоединенную) подпись к раннее подписанному документу (реализует метод coSign)
- [СryptoPro::addDetachedSignature()](docs/api/CryptoPro/addDetachedSignature.md) - добавляет отсоединенную (открепленную) подпись к раннее подписанному документу (реализует метод coSign)
- [СryptoPro::createHash()](docs/api/CryptoPro/createHash.md) - создает хеш сообщения по ГОСТ Р 34.11-2012 256 бит
- [СryptoPro::getSystemInfo()](docs/api/CryptoPro/getSystemInfo.md) - возвращает информацию о CSP и плагине
- [СryptoPro::isValidSystemSetup()](docs/api/CryptoPro/isValidSystemSetup.md) - возвращает флаг корректности настроек ЭП на машине


<a name="api-certificate"></a>
### Методы объекта сертификата