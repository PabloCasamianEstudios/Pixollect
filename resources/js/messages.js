const messages = {
    en: {
        //  Buttons
        Cancel: 'Cancel',
        Save: 'Save',
        Update: 'Update',
        YES: 'YES',
        NO: 'NO',

        // dialogs
        'Confirm removal': 'Confirm removal',
        'Are you sure you want to remove this game from your collection?':
            'Are you sure you want to remove this game from your collection?',
        Game: 'Game',
        'Release Year': 'Release Year',
        'Remove Game': 'Remove Game',
        'Are you sure?': 'Are you sure?',
        'Remove confirmation':
            'Are you sure you want to remove this game from your collection?',
        'Close session?': 'Close session?',
        'Are you sure you want to close session?':
            'Are you sure you want to close session?',

        // UserGameModal - Form fields
        'Start Date': 'Start Date',
        'End Date': 'End Date',
        'Hours Played': 'Hours Played',
        'User Score': 'Your Score',
        Mastered: 'Mastered',
        'Achievements Unlocked': 'Achievements Unlocked',
        of: 'of',
        achievements: 'achievements',

        // ERRORS
        'Score must be between 0 and 10': 'Score must be between 0 and 10',
        'Must be between 0 and': 'Must be between 0 and',
        'Hours cannot be negative': 'Hours cannot be negative',
        'Start date cannot be before release date':
            'Start date cannot be before release date',
        'End date cannot be before start date':
            'End date cannot be before start date',

        // Status options
        Completed: 'Completed',
        Playing: 'Playing',
        Backlog: 'Backlog',
        Wishlist: 'Wishlist',
        Dropped: 'Dropped',
        Planned: 'Planned',

        // Footer component translations
        About: 'About',
        'Contact Us': 'Contact Us',
        Terms: 'Terms',
        Privacy: 'Privacy',
        'User Help': 'User Help',
        Pixollect: 'Pixollect',
        // Navigation links
        HOME: 'HOME',
        GAMES: 'GAMES',
        COLLECTIONS: 'COLLECTIONS',
        RECOMMEND: 'RECOMMEND',
        COMPARE: 'COMPARE',
        'YOUR PROFILE': 'YOUR PROFILE',
        LOGOUT: 'LOGOUT',
        'ADMIN PANEL': 'ADMIN PANEL',
        LANGUAGE: 'LANGUAGE',

        // Auth buttons
        LOGIN: 'Login',
        REGISTER: 'Register',

        // Language names
        English: 'English',
        Español: 'Spanish',

        // USER LAYOUT
        'Change Avatar': 'Change Avatar',
        'User Avatar': 'User avatar',

        PROFILE: 'PROFILE',
        COLLECTION: 'COLLECTION',
        ACHIEVEMENTS: 'ACHIEVEMENTS',
        SETTINGS: 'SETTINGS',

        'Export CSV': 'Export CSV',

        'Error uploading avatar': 'Error uploading avatar',

        // FORGOT
        'Forgot Password': 'Forgot Password',

        'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.':
            'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',

        Email: 'Email',
        'Email Password Reset Link': 'Email Password Reset Link',

        'We have emailed your password reset link.':
            'We have emailed your password reset link.',
        'A fresh verification link has been sent to your email address.':
            'A fresh verification link has been sent to your email address.',

        // Login
        'Log in': 'Log in',

        Password: 'Password',
        'Remember me': 'Remember me',
        'Forgot your password?': 'Forgot your password?',

        // Register
        Register: 'Register',

        Name: 'Name',
        'Confirm Password': 'Confirm Password',

        'Already registered?': 'Already registered?',

        'Registration successful!': 'Registration successful!',
        'Error during registration': 'Error during registration',

        // TERMINOS Y CONDICIONES
        'Terms and Conditions': 'Terms and Conditions',
        'Terms and Conditions of Pixollect':
            'Terms and Conditions of Pixollect',

        'License of Use': 'License of Use',
        'Access and Modifications': 'Access and Modifications',
        'Intellectual Property': 'Intellectual Property',
        'Open Source Distribution': 'Open Source Distribution',

        'By accessing or using Pixollect, you agree to comply with the following terms and conditions. These terms are subject to change without prior notice. It is your responsibility to review them regularly.':
            'By accessing or using Pixollect, you agree to comply with the following terms and conditions. These terms are subject to change without prior notice. It is your responsibility to review them regularly.',

        'Pixollect is distributed under a non-exclusive usage license. Users are allowed to access and use the platform and all its functionalities free of charge. Redistribution or modification of the source code is strictly prohibited unless otherwise authorized by the developer.':
            'Pixollect is distributed under a non-exclusive usage license. Users are allowed to access and use the platform and all its functionalities free of charge. Redistribution or modification of the source code is strictly prohibited unless otherwise authorized by the developer.',

        'The developer reserves the right to modify the application at any time to improve functionality, correct errors, or add features. These changes will not negatively affect basic usability.':
            'The developer reserves the right to modify the application at any time to improve functionality, correct errors, or add features. These changes will not negatively affect basic usability.',

        'All intellectual property, including source code, databases, and visual content, belongs to the developer. Users may not claim ownership of any part of the platform.':
            'All intellectual property, including source code, databases, and visual content, belongs to the developer. Users may not claim ownership of any part of the platform.',

        'Pixollect is available as open source under the MIT License. You are allowed to view, use, copy, modify, and distribute the code with attribution to the original author. Commercial use requires prior permission from the developer.':
            'Pixollect is available as open source under the MIT License. You are allowed to view, use, copy, modify, and distribute the code with attribution to the original author. Commercial use requires prior permission from the developer.',

        // About
        'About Pixollect': 'About Pixollect',

        'What is Pixollect?': 'What is Pixollect?',
        'Project Objective': 'Project Objective',
        'Target Audience': 'Target Audience',
        'Technologies Used': 'Technologies Used',

        'Pixollect is a web application built to help gamers keep track of their video game collections. It centralizes all your games, no matter the platform or format, and provides tools for organizing, analyzing, and discovering new titles.':
            'Pixollect is a web application built to help gamers keep track of their video game collections. It centralizes all your games, no matter the platform or format, and provides tools for organizing, analyzing, and discovering new titles.',

        'The goal is to offer users a practical and user-friendly platform to manage their gaming libraries, track their progress, compare games, and receive personalized recommendations.':
            'The goal is to offer users a practical and user-friendly platform to manage their gaming libraries, track their progress, compare games, and receive personalized recommendations.',

        'Pixollect is designed for any gamer, whether casual or hardcore, who values collection tracking, stats, and game discovery based on personal preferences.':
            'Pixollect is designed for any gamer, whether casual or hardcore, who values collection tracking, stats, and game discovery based on personal preferences.',

        'Laravel (Backend)': 'Laravel (Backend)',
        'Inertia.js + Vue 3 (Frontend)': 'Inertia.js + Vue 3 (Frontend)',
        'MySQL (Database)': 'MySQL (Database)',
        'Chart.js (Statistics)': 'Chart.js (Statistics)',

        // CONTACT
        Contact: 'Contact',
        'Contact of Pixollect': 'Contact Pixollect',
        Message: 'Message',

        Send: 'Send',

        'Enter your name': 'Enter your name',
        'Enter your email': 'Enter your email',
        'Type your message here': 'Type your message here',

        'Your message has been sent successfully':
            'Your message has been sent successfully',

        'The name field is required': 'The name field is required',
        'The email field is required': 'The email field is required',
        'Please enter a valid email address':
            'Please enter a valid email address',
        'The message field is required': 'The message field is required',

        // PRIVACY
        'Privacy Policy': 'Privacy Policy',
        'Privacy Policy of Pixollect': 'Privacy Policy of Pixollect',

        'Pixollect respects your privacy. This policy explains what data we collect, why we collect it, and how we protect it. By using this platform, you consent to the practices described here.':
            'Pixollect respects your privacy. This policy explains what data we collect, why we collect it, and how we protect it. By using this platform, you consent to the practices described here.',

        'Data Collected': 'Data Collected',
        'Data Usage': 'Data Usage',
        'Data Protection': 'Data Protection',
        'User Rights': 'User Rights',
        Compliance: 'Compliance',

        'Username and email (for authentication)':
            'Username and email (for authentication)',
        'Your game collection and progress (statuses, achievements, hours, ratings)':
            'Your game collection and progress (statuses, achievements, hours, ratings)',
        'Basic usage data to improve the platform (e.g., preferences or filters)':
            'Basic usage data to improve the platform (e.g., preferences or filters)',

        'Your data is used solely to offer you the services of the platform: collection tracking, recommendations, comparisons, and statistics.':
            'Your data is used solely to offer you the services of the platform: collection tracking, recommendations, comparisons, and statistics.',

        'All personal data is securely stored. Passwords are encrypted using secure hashing. Sensitive operations are protected with role-based access and validated server-side.':
            'All personal data is securely stored. Passwords are encrypted using secure hashing. Sensitive operations are protected with role-based access and validated server-side.',

        'You may request deletion of your account and data at any time. We do not sell or share your data with third parties. Backup copies are made periodically to prevent loss.':
            'You may request deletion of your account and data at any time. We do not sell or share your data with third parties. Backup copies are made periodically to prevent loss.',

        'Pixollect follows the GDPR (General Data Protection Regulation) guidelines. Only the minimum required data is stored, and users retain control over their information.':
            'Pixollect follows the GDPR (General Data Protection Regulation) guidelines. Only the minimum required data is stored, and users retain control over their information.',

        // RECOMMEND
        Recomendator: 'Game Recommender',
        'Personalized game recommendations':
            'Personalized game recommendations',
        'Discover New Games': 'Discover New Games',
        'Based on your gaming preferences': 'Based on your gaming preferences',
        'Your Selected Games': 'Your Selected Games',
        "You've reviewed all recommendations!":
            "You've reviewed all recommendations!",
        'Come back tomorrow for new suggestions.':
            'Come back tomorrow for new suggestions.',
        'Games you disliked:': 'Games you disliked:',

        'You must be logged in to see recommendations':
            'You must be logged in to see recommendations',
        'User not authenticated': 'User not authenticated',
        'HTTP error! status: ${response.status}':
            'HTTP error! status: ${response.status}',
        'Error getting recommendations:': 'Error getting recommendations:',
        'Error loading recommendations. Please try again.':
            'Error loading recommendations. Please try again.',

        'SORRY!!!': 'SORRY!!!',
        'You must be logged in to get personalized game recommendations':
            'You must be logged in to get personalized game recommendations',

        // COLLECTIONS
        Collections: 'Collections',
        'Compare page of the application': 'Compare page of the application',

        'Search users...': 'Search users...',
        Avatar: 'Avatar',
        games: 'games',

        User: 'User',
        Admin: 'Admin',
        Mute: 'Mute',
        'Delete User': 'Delete User',

        // HOME
        Home: 'Home',
        'Welcome to Pixollect': 'Welcome to Pixollect',
        'Track, compare, and explore your video game collection with ease.':
            'Track, compare, and explore your video game collection with ease.',
        'Track Your Collection': 'Track Your Collection',
        'Keep record of all your games in one place':
            'Keep record of all your games in one place',
        'Find recommendations based on your taste':
            'Find recommendations based on your taste',
        'Achievement Tracking': 'Achievement Tracking',
        'Monitor your gaming progress and trophies':
            'Monitor your gaming progress and trophies',
        'TOTAL USERS': 'TOTAL USERS',
        'TOTAL GAMES': 'TOTAL GAMES',

        // COMPARATOR
        'Game Comparator': 'Game Comparator',
        'Compare your favorite games': 'Compare your favorite games',
        'Search game...': 'Search game...',
        ADD: 'ADD',
        TITLE: 'TITLE',
        COVER: 'COVER',
        PRICE: 'PRICE',
        DEVELOPER: 'DEVELOPER',
        'RELEASE DATE': 'RELEASE DATE',
        GENRES: 'GENRES',
        PLATFORMS: 'PLATFORMS',
        'GAME MODES': 'GAME MODES',
        THEMES: 'THEMES',
        SAGA: 'SAGA',
        'No games added yet. Start by searching and adding your favorite titles!':
            'No games added yet. Start by searching and adding your favorite titles!',
        'You Must be logged to start comparing videogames':
            'You must be logged in to start comparing video games',

        // Games Page
        'Games page of the application': 'Games page of the application',
        'Search...': 'Search...',
        'All Genres': 'All Genres',
        'All Platforms': 'All Platforms',
        'All Themes': 'All Themes',
        'All Sagas': 'All Sagas',

        // USER PROFILE
        'User profile page': 'User profile page',

        'Loading user data...': 'Loading user data...',
        'Error loading user data:': 'Error loading user data:',

        'Total Games:': 'Total Games:',
        'Total Hours:': 'Total Hours:',
        'Total Achievements:': 'Total Achievements:',
        'Total Spent:': 'Total Spent:',

        // Chart titles
        'Games by Genre': 'Games by Genre',
        'Games by State': 'Games by State',
        'Games Mastered': 'Games Mastered',
        'Library by Saga': 'Library by Saga',

        'NO GAMES': 'NO GAMES',
        'No games to calculate user stats': 'No games to calculate user stats',

        // SETTINGS
        Settings: 'Settings',

        'Account Settings': 'Account Settings',
        Username: 'Username',
        'Current Password': 'Current Password',
        'New Password': 'New Password',
        'Confirm New Password': 'Confirm New Password',

        'The email must be a valid email address':
            'The email must be a valid email address',
        'The current password field is required':
            'The current password field is required',
        'The current password is incorrect':
            'The current password is incorrect',
        'The password confirmation does not match':
            'The password confirmation does not match',
        'The password must be at least 8 characters':
            'The password must be at least 8 characters',

        'Profile updated successfully': 'Profile updated successfully',

        // USER ACHIIEVEMENTS SECTION

        "{user}'s Achievements": "{user}'s Achievements",

        Progress: 'Progress',

        Locked: 'Locked',
        Unlocked: 'Unlocked',

        'Complete your first game': 'Complete your first game',
        'Reach 100 hours played': 'Reach 100 hours played',
        'Master 10 games': 'Master 10 games',
        'Add 50 games to your collection': 'Add 50 games to your collection',
        // LOS ACHIEVEMENTS EN CUESTION

        // USER GAMES
        "{user}'s Games": "{user}'s Games",
        "{user}'s Collection": "{user}'s Collection",
        'Game collection page': 'Game collection page',

        'Search in collection...': 'Search in collection...',
        'All States': 'All States',

        Edit: 'Edit',
        Achievement: 'Achievement',
        Remove: 'Remove',

        EMPTY: 'EMPTY',
        'No games here': 'No games here',

        'Remove game?': 'Remove game?',
        'Increment achievement?': 'Increment achievement?',
        'Do you want to add one achievement to this game?':
            'Do you want to add one achievement to this game?',

        Error: 'Error',
        'Failed to increment achievement': 'Failed to increment achievement',

        // ADMIN PANEL
        'Admin Panel': 'Admin Panel',
        'Manage Tables': 'Manage Tables',

        // CRUDS
        'Manage Users': 'Manage Users',
        'Manage Sagas': 'Manage Sagas',
        'Manage Games': 'Manage Games',

        // Saga
        'Delete Saga': 'Delete Saga?',
        'Are you sure you want to delete this saga?':
            'Are you sure you want to delete this saga?',
        DELETE: 'DELETE',
        CANCEL: 'CANCEL',

        // User
        'Delete user?': 'Delete user?',
        'Are you sure you want to delete this user?':
            'Are you sure you want to delete this user?',

        // Game
        DELETE_GAME_TITLE: 'Delete Game?',
        DELETE_GAME_CONFIRMATION: 'Are you sure you want to delete this game?',

        // Game Detail Page
        'Game Details': 'Game Details',
        'Details for': 'Details for',
        'Game Cover': 'Game Cover',
        Players: 'Players',
        'Avg. Rating': 'Avg. Rating',
        'Game Rank': 'Game Rank',
        'Recent Players': 'Recent Players',
        'Released on': 'Released on',
        by: 'by',
        'and published by': 'and published by',
        Unknown: 'Unknown',
        'Add to your Collection': 'Add to your Collection',
        'Remove from Collection': 'Remove from Collection',
        'More from the': 'More from the',
        saga: 'saga',
        Platforms: 'Platforms',
        Genres: 'Genres',
        Themes: 'Themes',
        'Game Modes': 'Game Modes',

        'Error removing game:': 'Error removing game:',
        'NOT CLASSIFIED': 'Not Classified',
        // BETA ADVISE
        'BETA NOTICE': 'BETA NOTICE',
        'Pixollect is in beta.': 'Pixollect is in beta.',
        'Found a bug or want a game added?':
            'Found a bug or want a game added?',
        'Contact us': 'Contact us',
        'Include game info and a cover URL from':
            'Include game info and a cover URL from',

        //CONTACT
        'Need Help?': 'Need Help?',
        'Use this form to contact us for any of the following reasons:':
            'Use this form to contact us for any of the following reasons:',
        'I want to permanently delete my account':
            'I want to permanently delete my account',
        'I want to suggest a game that is not listed':
            'I want to suggest a game that is not listed',
        'I found a user violating the rules':
            'I found a user violating the rules',
        'I discovered a bug or technical issue':
            'I discovered a bug or technical issue',
    },
    es: {
        // Buttons
        Cancel: 'Cancelar',
        Save: 'Guardar',
        Update: 'Actualizar',
        YES: 'SÍ',
        NO: 'NO',

        // dialogs
        'Confirm removal': 'Confirmar eliminación',
        'Are you sure you want to remove this game from your collection?':
            '¿Estás seguro de que quieres eliminar este juego de tu colección?',
        Game: 'Juego',
        'Release Year': 'Año de lanzamiento',
        'Remove Game': 'Eliminar juego',
        'Are you sure?': '¿Estás seguro?',
        'Remove confirmation':
            '¿Estás seguro de que quieres eliminar este juego de tu colección?',
        'Close session?': '¿Cerrar sesión?',
        'Are you sure you want to close session?':
            '¿Estás seguro de que quieres cerrar sesión?',

        // UserGameModal - Form fields
        'Start Date': 'Fecha de inicio',
        'End Date': 'Fecha de finalización',
        'Hours Played': 'Horas jugadas',
        'User Score': 'Tu puntuación',
        Mastered: 'Dominado',
        'Achievements Unlocked': 'Logros desbloqueados',
        of: 'de',
        achievements: 'logros',

        // ERRORS
        'Score must be between 0 and 10':
            'La puntuación debe estar entre 0 y 10',
        'Must be between 0 and': 'Debe estar entre 0 y',
        'Hours cannot be negative': 'Las horas no pueden ser negativas',
        'Start date cannot be before release date':
            'La fecha de inicio no puede ser anterior a la de lanzamiento',
        'End date cannot be before start date':
            'La fecha de finalización no puede ser anterior a la de inicio',

        // Status options
        Completed: 'Completado',
        Playing: 'Jugando',
        Backlog: 'Backlog',
        Wishlist: 'Lista de deseos',
        Dropped: 'Abandonado',
        Planned: 'Pendiente',

        // Footer component translations
        About: 'Acerca de',
        'Contact Us': 'Contáctanos',
        Terms: 'Términos',
        Privacy: 'Privacidad',
        'User Help': 'Ayuda al usuario',
        Pixollect: 'Pixollect',

        // Navigation links
        HOME: 'INICIO',
        GAMES: 'JUEGOS',
        COLLECTIONS: 'COLECCIONES',
        RECOMMEND: 'RECOMENDADOR',
        COMPARE: 'COMPARADOR',
        'YOUR PROFILE': 'TU PERFIL',
        LOGOUT: 'CERRAR SESIÓN',
        'ADMIN PANEL': 'PANEL DE ADMIN',
        LANGUAGE: 'IDIOMA',

        // Auth buttons
        LOGIN: 'Iniciar sesión',
        REGISTER: 'Registrarse',

        // Language names
        English: 'Inglés',
        Español: 'Español',

        // USER LAYOUT
        'Change Avatar': 'Cambiar avatar',
        'User Avatar': 'Avatar de usuario',

        PROFILE: 'PERFIL',
        COLLECTION: 'COLECCIÓN',
        ACHIEVEMENTS: 'LOGROS',
        SETTINGS: 'AJUSTES',

        'Export CSV': 'Exportar CSV',

        'Error uploading avatar': 'Error al subir el avatar',

        // FORGOT
        'Forgot Password': 'Olvidé mi contraseña',

        'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.':
            '¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña que te permitirá elegir una nueva.',

        Email: 'Correo electrónico',
        'Email Password Reset Link':
            'Enviar enlace para restablecer contraseña',

        'We have emailed your password reset link.':
            'Hemos enviado el enlace para restablecer tu contraseña a tu correo.',
        'A fresh verification link has been sent to your email address.':
            'Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.',

        // Login
        'Log in': 'Iniciar sesión',

        Password: 'Contraseña',
        'Remember me': 'Recuérdame',
        'Forgot your password?': '¿Olvidaste tu contraseña?',

        // Register
        Register: 'Registrarse',

        Name: 'Nombre',
        'Confirm Password': 'Confirmar contraseña',

        'Already registered?': '¿Ya estás registrado?',

        'Registration successful!': '¡Registro exitoso!',
        'Error during registration': 'Error durante el registro',

        // TERMINOS Y CONDICIONES
        'Terms and Conditions': 'Términos y Condiciones',
        'Terms and Conditions of Pixollect':
            'Términos y Condiciones de Pixollect',

        'License of Use': 'Licencia de Uso',
        'Access and Modifications': 'Acceso y Modificaciones',
        'Intellectual Property': 'Propiedad Intelectual',
        'Open Source Distribution': 'Distribución de Código Abierto',

        'By accessing or using Pixollect, you agree to comply with the following terms and conditions. These terms are subject to change without prior notice. It is your responsibility to review them regularly.':
            'Al acceder o usar Pixollect, aceptas cumplir con los siguientes términos y condiciones. Estos términos pueden cambiar sin previo aviso. Es tu responsabilidad revisarlos regularmente.',

        'Pixollect is distributed under a non-exclusive usage license. Users are allowed to access and use the platform and all its functionalities free of charge. Redistribution or modification of the source code is strictly prohibited unless otherwise authorized by the developer.':
            'Pixollect se distribuye bajo una licencia de uso no exclusiva. Los usuarios pueden acceder y usar la plataforma y todas sus funcionalidades de forma gratuita. La redistribución o modificación del código fuente está estrictamente prohibida a menos que el desarrollador lo autorice.',

        'The developer reserves the right to modify the application at any time to improve functionality, correct errors, or add features. These changes will not negatively affect basic usability.':
            'El desarrollador se reserva el derecho de modificar la aplicación en cualquier momento para mejorar su funcionalidad, corregir errores o agregar características. Estos cambios no afectarán negativamente la usabilidad básica.',

        'All intellectual property, including source code, databases, and visual content, belongs to the developer. Users may not claim ownership of any part of the platform.':
            'Toda la propiedad intelectual, incluido el código fuente, bases de datos y contenido visual, pertenece al desarrollador. Los usuarios no pueden reclamar propiedad de ninguna parte de la plataforma.',

        'Pixollect is available as open source under the MIT License. You are allowed to view, use, copy, modify, and distribute the code with attribution to the original author. Commercial use requires prior permission from the developer.':
            'Pixollect está disponible como código abierto bajo la Licencia MIT. Puedes ver, usar, copiar, modificar y distribuir el código con atribución al autor original. El uso comercial requiere permiso previo del desarrollador.',

        // About
        'About Pixollect': 'Acerca de Pixollect',

        'What is Pixollect?': '¿Qué es Pixollect?',
        'Project Objective': 'Objetivo del Proyecto',
        'Target Audience': 'Público Objetivo',
        'Technologies Used': 'Tecnologías Utilizadas',

        'Pixollect is a web application built to help gamers keep track of their video game collections. It centralizes all your games, no matter the platform or format, and provides tools for organizing, analyzing, and discovering new titles.':
            'Pixollect es una aplicación web creada para ayudar a los jugadores a gestionar sus colecciones de videojuegos. Centraliza todos tus juegos, sin importar la plataforma o formato, y proporciona herramientas para organizar, analizar y descubrir nuevos títulos.',

        'The goal is to offer users a practical and user-friendly platform to manage their gaming libraries, track their progress, compare games, and receive personalized recommendations.':
            'El objetivo es ofrecer a los usuarios una plataforma práctica y fácil de usar para gestionar sus bibliotecas de juegos, seguir su progreso, comparar juegos y recibir recomendaciones personalizadas.',

        'Pixollect is designed for any gamer, whether casual or hardcore, who values collection tracking, stats, and game discovery based on personal preferences.':
            'Pixollect está diseñado para cualquier jugador, ya sea casual o hardcore, que valore el seguimiento de colecciones, estadísticas y descubrimiento de juegos basados en preferencias personales.',

        'Laravel (Backend)': 'Laravel (Backend)',
        'Inertia.js + Vue 3 (Frontend)': 'Inertia.js + Vue 3 (Frontend)',
        'MySQL (Database)': 'MySQL (Base de datos)',
        'Chart.js (Statistics)': 'Chart.js (Estadísticas)',

        // CONTACT
        Contact: 'Contacto',
        'Contact of Pixollect': 'Contacto de Pixollect',
        Message: 'Mensaje',

        Send: 'Enviar',

        'Enter your name': 'Ingresa tu nombre',
        'Enter your email': 'Ingresa tu correo electrónico',
        'Type your message here': 'Escribe tu mensaje aquí',

        'Your message has been sent successfully':
            'Tu mensaje ha sido enviado con éxito',

        'The name field is required': 'El campo nombre es requerido',
        'The email field is required':
            'El campo correo electrónico es requerido',
        'Please enter a valid email address':
            'Por favor ingresa un correo electrónico válido',
        'The message field is required': 'El campo mensaje es requerido',

        // PRIVACY
        'Privacy Policy': 'Política de Privacidad',
        'Privacy Policy of Pixollect': 'Política de Privacidad de Pixollect',

        'Pixollect respects your privacy. This policy explains what data we collect, why we collect it, and how we protect it. By using this platform, you consent to the practices described here.':
            'Pixollect respeta tu privacidad. Esta política explica qué datos recopilamos, por qué los recopilamos y cómo los protegemos. Al usar esta plataforma, aceptas las prácticas descritas aquí.',

        'Data Collected': 'Datos Recopilados',
        'Data Usage': 'Uso de Datos',
        'Data Protection': 'Protección de Datos',
        'User Rights': 'Derechos del Usuario',
        Compliance: 'Cumplimiento',

        'Username and email (for authentication)':
            'Nombre de usuario y correo electrónico (para autenticación)',
        'Your game collection and progress (statuses, achievements, hours, ratings)':
            'Tu colección de juegos y progreso (estados, logros, horas, calificaciones)',
        'Basic usage data to improve the platform (e.g., preferences or filters)':
            'Datos básicos de uso para mejorar la plataforma (ej. preferencias o filtros)',

        'Your data is used solely to offer you the services of the platform: collection tracking, recommendations, comparisons, and statistics.':
            'Tus datos se usan únicamente para ofrecerte los servicios de la plataforma: seguimiento de colección, recomendaciones, comparaciones y estadísticas.',

        'All personal data is securely stored. Passwords are encrypted using secure hashing. Sensitive operations are protected with role-based access and validated server-side.':
            'Todos los datos personales se almacenan de forma segura. Las contraseñas se cifran usando hash seguro. Las operaciones sensibles están protegidas con acceso basado en roles y validación del lado del servidor.',

        'You may request deletion of your account and data at any time. We do not sell or share your data with third parties. Backup copies are made periodically to prevent loss.':
            'Puedes solicitar la eliminación de tu cuenta y datos en cualquier momento. No vendemos ni compartimos tus datos con terceros. Se realizan copias de seguridad periódicamente para prevenir pérdidas.',

        'Pixollect follows the GDPR (General Data Protection Regulation) guidelines. Only the minimum required data is stored, and users retain control over their information.':
            'Pixollect sigue las pautas del GDPR (Reglamento General de Protección de Datos). Solo se almacenan los datos mínimos necesarios y los usuarios mantienen control sobre su información.',

        // RECOMMEND
        Recomendator: 'Recomendador de Juegos',
        'Personalized game recommendations':
            'Recomendaciones de juegos personalizadas',
        'Discover New Games': 'Descubre Nuevos Juegos',
        'Based on your gaming preferences':
            'Basado en tus preferencias de juego',
        'Your Selected Games': 'Tus Juegos Seleccionados',
        "You've reviewed all recommendations!":
            '¡Has revisado todas las recomendaciones!',
        'Come back tomorrow for new suggestions.':
            'Vuelve mañana por nuevas sugerencias.',
        'Games you disliked:': 'Juegos que no te gustaron:',

        'You must be logged in to see recommendations':
            'Debes iniciar sesión para ver recomendaciones',
        'User not authenticated': 'Usuario no autenticado',
        'HTTP error! status: ${response.status}':
            '¡Error HTTP! estado: ${response.status}',
        'Error getting recommendations:': 'Error al obtener recomendaciones:',
        'Error loading recommendations. Please try again.':
            'Error al cargar recomendaciones. Por favor, inténtalo de nuevo.',

        'SORRY!!!': '¡LO SENTIMOS!',
        'You must be logged in to get personalized game recommendations':
            'Debes iniciar sesión para obtener recomendaciones de juegos personalizadas',

        // COLLECTIONS
        Collections: 'Colecciones',
        'Compare page of the application':
            'Página de comparación de la aplicación',

        'Search users...': 'Buscar usuarios...',
        Avatar: 'Avatar',
        games: 'juegos',

        User: 'Usuario',
        Admin: 'Administrador',
        Mute: 'Silenciado',
        'Delete User': 'Eliminar Usuario',

        // HOME
        Home: 'Inicio',
        'Welcome to Pixollect': 'Bienvenido a Pixollect',
        'Track, compare, and explore your video game collection with ease.':
            'Rastrea, compara y explora tu colección de videojuegos con facilidad.',
        'Track Your Collection': 'Rastrea tu Colección',
        'Keep record of all your games in one place':
            'Mantén un registro de todos tus juegos en un solo lugar',
        'Find recommendations based on your taste':
            'Encuentra recomendaciones basadas en tu gusto',
        'Achievement Tracking': 'Seguimiento de Logros',
        'Monitor your gaming progress and trophies':
            'Controla tu progreso y trofeos en los juegos',
        'TOTAL USERS': 'USUARIOS TOTALES',
        'TOTAL GAMES': 'JUEGOS TOTALES',

        // COMPARATOR
        'Game Comparator': 'Comparador de Juegos',
        'Compare your favorite games': 'Compara tus juegos favoritos',
        'Search game...': 'Buscar juego...',
        ADD: 'AÑADIR',
        TITLE: 'TÍTULO',
        COVER: 'PORTADA',
        PRICE: 'PRECIO',
        DEVELOPER: 'DESARROLLADOR',
        'RELEASE DATE': 'FECHA DE LANZAMIENTO',
        GENRES: 'GÉNEROS',
        PLATFORMS: 'PLATAFORMAS',
        'GAME MODES': 'MODOS DE JUEGO',
        THEMES: 'TEMÁTICAS',
        SAGA: 'SAGA',
        'No games added yet. Start by searching and adding your favorite titles!':
            'Aún no hay juegos añadidos. ¡Empieza buscando y añadiendo tus títulos favoritos!',
        'You Must be logged to start comparing videogames':
            'Debes iniciar sesión para empezar a comparar videojuegos',

        // Games Page
        'Games page of the application': 'Página de juegos de la aplicación',
        'Search...': 'Buscar...',
        'All Genres': 'Todos los Géneros',
        'All Platforms': 'Todas las Plataformas',
        'All Themes': 'Todas las Temáticas',
        'All Sagas': 'Todas las Sagas',

        // USER PROFILE
        'User profile page': 'Página de perfil de usuario',

        'Loading user data...': 'Cargando datos del usuario...',
        'Error loading user data:': 'Error al cargar datos del usuario:',

        'Total Games:': 'Juegos Totales:',
        'Total Hours:': 'Horas Totales:',
        'Total Achievements:': 'Logros Totales:',
        'Total Spent:': 'Total Gastado:',

        // Chart titles
        'Games by Genre': 'Juegos por Género',
        'Games by State': 'Juegos por Estado',
        'Games Mastered': 'Juegos Dominados',
        'Library by Saga': 'Biblioteca por Saga',

        'NO GAMES': 'SIN JUEGOS',
        'No games to calculate user stats':
            'No hay juegos para calcular estadísticas',

        // SETTINGS
        Settings: 'Configuración',

        'Account Settings': 'Configuración de Cuenta',
        Username: 'Nombre de usuario',
        'Current Password': 'Contraseña Actual',
        'New Password': 'Nueva Contraseña',
        'Confirm New Password': 'Confirmar Nueva Contraseña',

        'The email must be a valid email address':
            'El correo electrónico debe ser válido',
        'The current password field is required':
            'El campo contraseña actual es requerido',
        'The current password is incorrect':
            'La contraseña actual es incorrecta',
        'The password confirmation does not match':
            'La confirmación de contraseña no coincide',
        'The password must be at least 8 characters':
            'La contraseña debe tener al menos 8 caracteres',

        'Profile updated successfully': 'Perfil actualizado con éxito',

        // USER ACHIEVEMENTS SECTION
        "{user}'s Achievements": 'Logros de {user}',

        Progress: 'Progreso',

        Locked: 'Bloqueado',
        Unlocked: 'Desbloqueado',

        'Complete your first game': 'Completa tu primer juego',
        'Reach 100 hours played': 'Alcanza 100 horas jugadas',
        'Master 10 games': 'Domina 10 juegos',
        'Add 50 games to your collection': 'Añade 50 juegos a tu colección',

        // USER GAMES
        "{user}'s Games": 'Juegos de {user}',
        "{user}'s Collection": 'Colección de {user}',
        'Game collection page': 'Página de colección de juegos',

        'Search in collection...': 'Buscar en colección...',
        'All States': 'Todos los Estados',

        Edit: 'Editar',
        Achievement: 'Logro',
        Remove: 'Eliminar',

        EMPTY: 'VACÍO',
        'No games here': 'No hay juegos aquí',

        'Remove game?': '¿Eliminar juego?',
        'Increment achievement?': '¿Incrementar logro?',
        'Do you want to add one achievement to this game?':
            '¿Quieres añadir un logro a este juego?',

        Error: 'Error',
        'Failed to increment achievement': 'Error al incrementar logro',

        // ADMIN PANEL
        'Admin Panel': 'Panel de Administración',
        'Manage Tables': 'Gestionar Tablas',

        // CRUDS
        'Manage Users': 'Gestionar Usuarios',
        'Manage Sagas': 'Gestionar Sagas',
        'Manage Games': 'Gestionar Juegos',

        // Saga
        'Delete Saga': '¿Eliminar Saga?',
        'Are you sure you want to delete this saga?':
            '¿Estás seguro de que quieres eliminar esta saga?',
        DELETE: 'ELIMINAR',
        CANCEL: 'CANCELAR',

        // User
        'Delete user?': '¿Eliminar usuario?',
        'Are you sure you want to delete this user?':
            '¿Estás seguro de que quieres eliminar este usuario?',

        // Game
        DELETE_GAME_TITLE: '¿Eliminar Juego?',
        DELETE_GAME_CONFIRMATION:
            '¿Estás seguro de que quieres eliminar este juego?',

        // Game Detail Page
        'Game Details': 'Detalles del Juego',
        'Details for': 'Detalles de',
        'Game Cover': 'Portada del Juego',
        Players: 'Jugadores',
        'Avg. Rating': 'Puntuación Promedio',
        'Game Rank': 'Ranking del Juego',
        'Recent Players': 'Jugadores Recientes',
        'Released on': 'Lanzado el',
        by: 'por',
        'and published by': 'y publicado por',
        Unknown: 'Desconocido',
        'Add to your Collection': 'Añadir a tu Colección',
        'Remove from Collection': 'Eliminar de la Colección',
        'More from the': 'Más de la',
        saga: 'saga',
        Platforms: 'Plataformas',
        Genres: 'Géneros',
        Themes: 'Temáticas',
        'Game Modes': 'Modos de Juego',
        'Error removing game:': 'Error al eliminar juego:',
        'NOT CLASSIFIED': 'Sin clasificar',

         // BETA ADVISE
        'BETA NOTICE': 'AVISO DE BETA',
        'Pixollect is in beta.': 'Pixollect está en beta.',
        'Found a bug or want a game added?':
            '¿Encontraste un error o quieres que añadamos un juego?',
        'Contact us': 'Contáctanos',
        'Include game info and a cover URL from':
            'Incluye la información del juego y una URL de portada desde',

        // CONTACT
        'Need Help?': '¿Necesitas ayuda?',
        'Use this form to contact us for any of the following reasons:':
            'Usa este formulario para contactarnos por cualquiera de las siguientes razones:',
        'I want to permanently delete my account':
            'Quiero eliminar mi cuenta de forma permanente',
        'I want to suggest a game that is not listed':
            'Quiero sugerir un juego que no está registrado',
        'I found a user violating the rules':
            'He encontrado a un usuario que está rompiendo las reglas',
        'I discovered a bug or technical issue':
            'He encontrado un error o problema técnico',

    },
};

export default messages;
