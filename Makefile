build:
	docker build -t ddd-calendar-api .
run:
	docker run -d -p 8080:80 --name calendar-api-container ddd-calendar-api
run-attached:
	# docker run -d -p 8080:80 --name calendar-api-container -v /locatio/of/your/container/ddd-calendar-api:/var/www/html ddd-calendar-api
	docker run -d -p 8080:80 --name calendar-api-container -v /Volumes/projects/ddd-calendar-api:/var/www/html ddd-calendar-api

