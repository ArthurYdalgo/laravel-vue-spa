# Plant Tech

- Copie o .env.example e altere o nome para .env
- Crie um schema com o nome "planttech"
- Execute:
```
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate:fresh --seed
npm install
```

Para compilar o projeto Vue em desenvolvimento:

```
npm run dev
```

ou use 
```
npm run hot
```
para reload automático.

Para compilar o projeto para produção, rode:
```
npm run build
```