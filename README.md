# TechRazzi Etkinlik Yönetim Uygulaması

TechRazzi, etkinliklerin yönetildiği bir web uygulamasıdır. Etkinliklerle ilgili detayların görüntülenmesini, kullanıcıların etkinliklere katılımının yönetilmesini ve yorum yapılmasını sağlar. Uygulama, Laravel framework kullanılarak geliştirilmiştir ve REST API üzerinden işlemleri destekler.

## Uygulama Bileşenleri
### Modeller:
- **User:** Kullanıcıları temsil eder. Etkinliklere katılım ve yorum yapma işlemleri bu model üzerinden gerçekleştirilir.
- **Event:** Etkinlikleri temsil eder. Etkinlik detayları, başlangıç ve bitiş zamanları, mekan bilgisi gibi bilgileri içerir.
- **Venue:** Etkinlik mekanlarını temsil eder. Mekanın adı, şehri ve ülkesi gibi bilgileri barındırır.
- **Comment:** Etkinliklere yapılan yorumları temsil eder. Her yorum bir kullanıcı ve etkinlik ile ilişkilendirilir.
- **Talk:** Etkinliklerde gerçekleştirilen konuşmaları temsil eder. Konuşmanın başlığı, özeti ve süresi gibi bilgileri içerir.
- **Speaker:** Konuşmacıları temsil eder. Konuşmacının adı, soyadı, unvanı ve bağlı olduğu şirket bilgileri yer alır.

## Repository ve Service Katmanları
- **Repository Katmanı:** Veritabanı işlemlerinin yapıldığı katmandır. CRUD işlemleri burada tanımlanır.
- **Service Katmanı:** Uygulama mantığının yazıldığı katmandır. Controller'dan gelen verileri işleyerek Repository katmanına ileten metodlar bu katmanda yer alır.

## Controllerlar
- **EventController:** Etkinliklerle ilgili işlemleri yönetir. Etkinlik listeleme, etkinlik detay görüntüleme ve kullanıcı etkinlik katılım durumunu değiştirme işlemleri bu controller üzerinden yapılır.
- **CommentController:** Yorumlarla ilgili işlemleri yönetir. Yorum ekleme ve kullanıcıya ait yorumları listeleme işlemleri bu controller üzerinden yapılır.

## API Endpoint'ler
```
* /api/events: Etkinlikleri listeler.
* /api/events/{id}: Belirli bir etkinliğin detaylarını gösterir.
* /api/comment: Yeni bir yorum ekler.
* /api/events/{event}/toggle-participation: Kullanıcının etkinlikteki katılım durumunu değiştirir.
* /api/user/events: Giriş yapmış kullanıcının katıldığı etkinlikleri listeler.
* /api/user/comments: Giriş yapmış kullanıcının yaptığı yorumları listeler.
```

## Kurulum
#### Bağımlılıkların Yüklenmesi:

````
composer install
````

#### Veritabanı ve Ortam Dosyası Ayarları:
````
Veritabanı ayarlarınızı yapmak için .env dosyasını düzenleyin. Bu dosya içerisinde veritabanı bağlantı bilgilerini güncelleyin.
````

#### Veritabanı Migrasyonlarının Çalıştırılması:
````
php artisan migrate 
# or
php artisan migrate --seed
````

#### Uygulamanın Çalıştırılması:
````
php artisan serve
````
