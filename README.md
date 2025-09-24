# Лабораторная работа №1: Nginx + Docker

## 👩‍💻 Автор
ФИО: Юрова Елена Витальевна

Группа: 3МО РБД-2

---

## 📌 Описание задания
Создать веб-сервер в Docker с использованием Nginx и подключить HTML-страницу.  
Результат доступен по адресу [http://localhost:8080](http://localhost:8080).

---

## ⚙️ Как запустить проект

1. Клонировать репозиторий:
   ```bash
   git clone (https://github.com/hellyu21/repoYuL.git)
   cd nginx-lab
Запустить контейнеры:
```bash
docker-compose up -d --build
```
Открыть в браузере:
```http://localhost:8080```
📂 Содержимое проекта

```docker-compose.yml``` — описание сервиса Nginx

```code/index.html``` — главная HTML-страница

```screenshots/``` — все скриншоты

📸 Скриншоты работы

Docker установлен

![Скриншот 22-09-2025 224039](https://github.com/user-attachments/assets/1428ea97-639a-47d0-bce8-85986ef59748)

Создан docker-compose.yml

![Скриншот 24-09-2025 120102](https://github.com/user-attachments/assets/9c5cf90a-527d-44d8-a62b-4abf570795c6)

Добавлен и изменен html

![Скриншот 24-09-2025 120944](https://github.com/user-attachments/assets/d6d7ebbe-2c81-43a5-b0ae-50a64f33d14e)

Добавлен второй файл html - about.html
![Скриншот 24-09-2025 121215](https://github.com/user-attachments/assets/0961799b-413d-4e6b-a45e-a8003acabd7f)

Изменен стандартный порт на 3000
![Скриншот 24-09-2025 121358](https://github.com/user-attachments/assets/71a73a18-b33e-4cb5-90d3-3070ea186107)


✅ Результат
Сервер в Docker успешно запущен, Nginx отдаёт мою HTML-страницу.
