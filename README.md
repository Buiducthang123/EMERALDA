<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Cài đặt

#### Lưu ý nên mở xampp rùi làm gì thì làm nhoa =))
1. Clone repository:
    ```sh
    git clone git@github.com:Buiducthang123/EMERALDA.git
    ```
2. Điều hướng đến thư mục dự án:
    ```sh
    cd your-project
    ```
3. Cài đặt các phụ thuộc bằng Composer:
    ```sh
    composer install
    ```
4. Sao chép file `.env.example` thành `.env` ( nếu đã có .env thì có thể bỏ qua ) :
    ```sh
    cp .env.example .env
    ```
5. Tạo khóa ứng dụng: ( nếu bạn đã có file .env thì có thể bỏ qua)
    ```sh
    php artisan key:generate
    ```
6. Thiết lập thông tin cơ sở dữ liệu trong file `.env`.
7. Chạy các migration cơ sở dữ liệu:
    ```sh
    php artisan migrate
    ```
8. Chạy các seeder để tạo dữ liệu ảo (lưu ý chỉ chạy một lần) :
    ```sh
    php artisan db:seed 
    ```
9. Tài khoản Admin mặc định khi tạo dữ liệu ảo :
    <br>
    Tài khoản:

    ```sh
    admin@gmail.com
    ```
    Mật khẩu:
    ```sh
    123456
    ```
    
    
    
## Sử dụng

1. Khởi động server phát triển:
    ```sh
    php artisan serve
    ```
2. Mở trình duyệt và truy cập `http://localhost:8000`.
3. Tối ưu hóa hiệu suất của ứng dụng bằng cách tạo và lưu trữ các tệp tin cache:
    ```sh
    php artisan optimize

## Đóng góp

Cảm ơn bạn đã xem xét đóng góp cho framework Laravel! Hướng dẫn đóng góp có thể được tìm thấy trong [tài liệu Laravel](https://laravel.com/docs/contributions).

## Lời cảm ơn

Chúc bạn một ngày tốt lành !

<p align="center">
<img width="500" src="https://hoanghamobile.com/tin-tuc/wp-content/uploads/2023/09/meme-che-15.jpg"/>
</p>
