# Halloween Contact Manager Website

Welcome to the Halloween Contact Manager Website! This spooky-themed contact management system allows users to keep track of their contacts with a Halloween twist. Built on the LAMP stack and dockerized for easy deployment, this web application provides a seamless and eerie user experience.

## Table of Contents
1. [Technology Stack](#technology-stack)
2. [Setup Instructions](#setup-instructions)
3. [Features](#features)

## Technology Stack
- **Operating System:** Linux
- **Web Server:** Apache
- **Database:** MySQL
- **Backend:** PHP
- **Containerization:** Docker

## Setup Instructions
1. **Docker Setup**
    - Ensure Docker and Docker Compose are installed on your machine.
    - Clone this repository to your machine.
    - Navigate to the project directory in your terminal.

2. **Building and Running the Docker Containers**
    ```bash
    docker-compose up --build -d
    ```

3. **Accessing the Website**
    - Once the Docker containers are up and running, open your web browser and navigate to `http://localhost/` to access the Halloween Contact Manager Website.

4. **Stopping the Docker Containers**
    ```bash
    docker-compose down
    ```

## Features
- **Spooky UI:** A Halloween-themed user interface that provides a unique user experience.
- **Contact Management:** Add, edit, delete, and view contacts.
- **Search Functionality:** Easily search and filter your contacts.
