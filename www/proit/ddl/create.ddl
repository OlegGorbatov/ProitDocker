CREATE DATABASE proit_test;

USE proit_test;

CREATE TABLE `content` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `fio` VARCHAR(255) NOT NULL DEFAULT 'fio' COLLATE 'utf8mb4_unicode_ci',
    `email` VARCHAR(255) NOT NULL DEFAULT 'email' COLLATE 'utf8mb4_unicode_ci',
    `telephone` VARCHAR(50) NOT NULL DEFAULT 'telephone' COLLATE 'utf8mb4_unicode_ci',
    `city` VARCHAR(100) NOT NULL DEFAULT 'city' COLLATE 'utf8mb4_unicode_ci',
    `address` VARCHAR(500) NOT NULL DEFAULT 'address' COLLATE 'utf8mb4_unicode_ci',
    PRIMARY KEY (`id`) USING BTREE
)
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB
;

INSERT INTO `proit_test`.`content` (`fio`, `email`, `telephone`, `city`, `address`) VALUES ('Тарас Иванович Шевченко', 'bulba@mail.ru', '+79781237890', 'Киев', 'Шевченко 11, кв 3');
INSERT INTO `proit_test`.`content` (`fio`, `email`, `telephone`, `city`, `address`) VALUES ('Лев Николаевич Толстой', 'tolstoy@yandex.ru', '+79257548515', 'Москва', 'Кремль 1');
INSERT INTO `proit_test`.`content` (`fio`, `email`, `telephone`, `city`, `address`) VALUES ('Петров Иван Сергеевич', 'etrov@google.com', '+79181761328', 'Пермь', 'Краснозаводская 4, кв 1');
INSERT INTO `proit_test`.`content` (`fio`, `email`, `telephone`, `city`, `address`) VALUES ('Иванов Пётр Захарович', 'ivanov@rambler.ru', '+791215478778', 'Краснодар', 'Зелёный переулок 17, кв 23');
INSERT INTO `proit_test`.`content` (`fio`, `email`, `telephone`, `city`, `address`) VALUES ('Мкртчян Генрик Бедросович', 'mkrtchan@yandex.ru', '+79283157878', 'Москва', 'Фестивальная 13, кв 8');

