Feature: оформление заказа
  Как пользователь я хочу совершать покупки online

  Scenario:
    Given В корзине находится товар на сумму 30 000 рублей
    And Я добавляю в корзину еще товар на сумму 5 000 рублей
    When Я перехожу к процессу оформления
    Then Я ожидаю увидеть что общее количество единиц товара равно 2 шт
    And Сумма заказа составляет 35 000 рублей