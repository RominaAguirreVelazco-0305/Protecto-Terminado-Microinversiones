<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Inversión</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.2);
            border-radius: 8px;
            background-color: #ffffff;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            width: 75%;
            display: block;
            margin: auto;
        }
        h1 {
    margin-bottom: 40px; /* Aumenta el espacio debajo del título */
}

img {
    margin: 20px auto 40px; /* Aumenta el espacio debajo de la imagen */
}

p {
    margin-bottom: 20px; /* Mantiene el espacio debajo de cada párrafo, incluida la descripción */
}
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-regresar {
            background-color: #6c757d;
            color: white;
            margin-top: 20px;
        }
        .btn-regresar:hover {
            background-color: #5a6268;
        }
        .btn-danger {
            background-color: red;
            color: white;
        }
        .btn-danger:hover {
            background-color: darkred;
        }

        /* Estilos específicos para modo oscuro */
        body.dark-mode {
            background-color: #333; /* Fondo oscuro */
            color: #fff; /* Texto claro */
        }
        body.dark-mode .container {
            background-color: #333;
            color: #fff;
        }
        body.dark-mode .btn {
            background-color: #5a5a5a;
        }
        body.dark-mode .btn:hover {
            background-color: #404040;
        }
        body.dark-mode .btn-danger {
            background-color: #004080; /* Azul oscuro para modo oscuro */
        }
        body.dark-mode .btn-danger:hover {
            background-color: #002060; /* Un azul más oscuro para hover en modo oscuro */
        }

        /* Otras definiciones de estilos para comentarios, formulario, etc. */
        .form-container {
            margin-top: 40px;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container .form-group {
            margin-bottom: 15px;
        }

        .form-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
        }

        .form-container textarea, .form-container select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container button {
            margin-top: 10px;
        }

        .review-container {
            margin-top: 40px;
        }
        .review {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stars {
            display: flex;
        }
        .stars i {
            color: #FFD700;
        }

        .average-rating {
            margin-top: 20px;
        }

        .rating {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .rating i {
            font-size: 30px;
            cursor: pointer;
            transition: color 0.3s;
        }
        .rating i:hover,
        .rating i.active {
            color: #FFD700;
        }
        body.dark-mode .form-container textarea,
    body.dark-mode .form-container input,
    body.dark-mode .form-container select {
        background-color: #555;
        color: #fff;
        border-color: #777;
    }
    </style>
    <body class="{{ (session('darkMode') === true) ? 'dark-mode' : '' }}">

</head>
<body class="{{ (session('darkMode') === true) ? 'dark-mode' : '' }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles de la Inversión
        </h2>
    </x-slot>

    <div class="container">
        <div>
            <h1>{{ $investment->title }}</h1>
            <img src="{{ asset('storage/' . $investment->image) }}" alt="Imagen representativa de la inversión: {{ $investment->title }}">
            <p><strong>Descripcion: </strong>{{ $investment->description }}</p>
            <p><strong>Objetivo de Recaudación: </strong>${{ number_format($investment->goal_amount, 2) }}</p>
            <p><strong>Total Recaudado: </strong>${{ number_format($investment->raised_amount, 2) }}</p>
            <p><strong>Inversores: </strong>{{ $investment->investor_count }}</p>
            <a href="{{ route('investments.form', $investment->id) }}" class="btn btn-primary">Invertir Ahora</a>
            <a href="{{ url()->previous() }}" class="btn btn-regresar">Regresar</a>
        </div>

        <!-- Sección de comentarios -->
        <div class="review-container">
            <h2>Comentarios</h2>
            
            @foreach ($reviews as $review)
                <div class="review">
                    <div class="review-header">
                        <strong>{{ $review->user->name }}</strong> <!-- Mostrar nombre del usuario -->
                        @if (Auth::id() === $review->user_id)
                        <!-- Eliminar comentario si es el usuario que lo creó -->
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    @endif
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
            @endforeach
        </div>

        <!-- Sección de formulario de comentarios -->
        <div class="form-container">
            <h2>Deja un comentario</h2>
            @auth
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="comment">Comentario:</label>
                    <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Agregar comentario</button>
            </form>
            @endauth
        </div>

        <!-- Sección de calificación -->
        <div class="form-container">
            <h2>Califica esta inversión</h2>

            <!-- Mostrar promedio de calificaciones -->
            <div class="average-rating">
                <strong>Promedio de calificación:</strong> 
                <span class="stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star{{ $i <= $averageRating ? '' : '-o' }}"></i>
                    @endfor
                </span> ({{ number_format($averageRating, 1) }} / 5)
            </div>

            <!-- Formulario para agregar una calificación -->
            @auth
            <form action="{{ route('ratings.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rating">Tu calificación:</label>
                    <div class="rating">
                        <i class="fa fa-star" data-value="1"></i>
                        <i class="fa fa-star" data-value="2"></i>
                        <i class="fa fa-star" data-value="3"></i>
                        <i class="fa fa-star" data-value="4"></i>
                        <i class="fa fa-star" data-value="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="rating-value" value="1">
                </div>
                <button type="submit" class="btn btn-primary">Enviar calificación</button>
            </form>
            @endauth
        </div>

    </div>
</x-app-layout>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    // JavaScript para manejar la interacción de las estrellas
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.rating i');
        const ratingValue = document.getElementById('rating-value');
        stars.forEach(star => {
            star.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                ratingValue.value = value;

                // Quitar la clase 'active' de todas las estrellas
                stars.forEach(s => s.classList.remove('active'));

                // Agregar la clase 'active' a las estrellas seleccionadas
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('active');
                }
            });

            star.addEventListener('mouseover', function () {
                // Resaltar las estrellas al pasar el cursor
                const value = this.getAttribute('data-value');
                stars.forEach(s => s.classList.remove('active'));
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('active');
                }
            });

            star.addEventListener('mouseout', function () {
                // Restaurar la selección de estrellas al quitar el cursor
                const value = ratingValue.value;
                stars.forEach(s => s.classList.remove('active'));
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('active');
                }
            });
        });
    });
</script>
</body>
</html>
