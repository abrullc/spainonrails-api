Pasos a seguir para la configuración
1. Clonar el repositorio
'''gitclone ...'''
2. Configurar el archivo .env
'''cp .env .env.local'''
2. Instalar las dependencias
'''docker compose up -d'''
'''docker compose exec web bash'''
'''composer install'''
4. Ejecutar el proyecto
'''mysql -u root -pdbrootpass -h add-dbms < db/spainOnRails.sql'''