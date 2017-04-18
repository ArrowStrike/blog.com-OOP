<?php

class Pagination
{

    //Ссылок навигации на страницу
    private $max = 7;

    //Ключ для GET, в который пишется номер страницы
    private $index = 'page-';

    //Текущая страница
    private $currentPage;

    //Общее количество записей
    private $total;

    //Записей на страницу
    private $limit;

    //Запуск необходимых данных для навигации
    public function __construct($total, $currentPage, $limit, $index)
    {
        $this->total = $total;
        $this->limit = $limit;
        $this->index = $index;
        $this->amount = $this->amount();
        $this->setCurrentPage($currentPage);
    }


    //HTML-код со ссылками навигации
    public function get()
    {
        # Для записи ссылок
        $links = null;

        # Получаем ограничения для цикла
        $limits = $this->limits();

        $html = '<ul class="paginationCenter">';
        # Генерируем ссылки
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            # Если текущая это текущая страница, ссылки нет и добавляется класс active
            if ($page == $this->currentPage) {
                $links .= '<maza>' . $page . '</maza>';
            } else {
                # Иначе генерируем ссылку
                $links .= $this->generateHtml($page);
            }
        }

        # Если ссылки создались
        if (!is_null($links)) {
            # Если текущая страница не первая
            if ($this->currentPage > 1)
                # Создаём ссылку "На первую"
                $links = $this->generateHtml(1, '&laquo;') . $links;

            # Если текущая страница не первая
            if ($this->currentPage < $this->amount)
                # Создаём ссылку "На последнюю"
                $links .= $this->generateHtml($this->amount, '&raquo;');
        }

        $html .= $links . '</ul>';

        # Возвращаем html
        return $html;
    }

    //Для генерации HTML-кода ссылки
    private function generateHtml($page, $text = null)
    {
        # Если текст ссылки не указан
        if (!$text)
            # Указываем, что текст - цифра страницы
            $text = $page;

        $currentURI = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
        $currentURI = preg_replace('~/page-[0-9]+~', '', $currentURI);

        # Формируем HTML код ссылки и возвращаем
        return
            '<a href="' . $currentURI . $this->index . $page . '">' . '     ' . $text . '     ' . '</a>';
    }


    // Для получения, откуда стартовать
    private function limits()
    {
        # Вычисляем ссылки слева (чтобы активная ссылка была посередине)
        $left = $this->currentPage - round($this->max / 2);

        # Вычисляем начало отсчёта
        $start = $left > 0 ? $left : 1;

        # Если впереди есть как минимум $this->max страниц
        if ($start + $this->max <= $this->amount) {
            # Назначаем конец цикла вперёд на $this->max страниц или просто на минимум
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            # Конец - общее количество страниц
            $end = $this->amount;

            # Начало - минус $this->max от конца
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }

        # Возвращаем массив с началом и концом отсчёта
        return array($start, $end);
    }


    //Для установки текущей страницы
    private function setCurrentPage($currentPage)
    {
        # Получаем номер страницы
        $this->currentPage = $currentPage;

        # Если текущая страница больше нуля
        if ($this->currentPage > 0) {
            # Если текущая страница меньше общего количества страниц
            if ($this->currentPage > $this->amount)
                # Устанавливаем страницу на последнюю
                $this->currentPage = $this->amount;
        } else
            # Устанавливаем страницу на первую
            $this->currentPage = 1;
    }


    //Для получения общего числа страниц
    private function amount()
    {
        # Делим и возвращаем число страниц
        return ceil($this->total / $this->limit);
    }

}