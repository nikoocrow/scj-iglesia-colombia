<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerarEstudiantesCSV extends Command
{
    protected $signature   = 'app:generar-csv {cantidad=1000 : Número de estudiantes a generar}';
    protected $description = 'Genera un CSV con estudiantes de prueba';

    public function handle()
    {
        $nombres = [
            'Santiago','Valentina','Juan','María','Camilo','Daniela','Andrés','Laura',
            'Sebastián','Ana','Miguel','Sofía','David','Isabella','Felipe','Natalia',
            'Julián','Carolina','Nicolás','Alejandra','Samuel','Gabriela','Diego','Mariana',
            'Tomás','Luisa','Mateo','Paula','Ricardo','Valeria','Esteban','Paola',
            'Sergio','Monica','Carlos','Juliana','Javier','Lorena','Pedro','Adriana',
            'Gabriel','Lina','Mauricio','Claudia','Alejandro','Diana','Jorge','Andrea',
            'Rafael','Melissa','Fabio','Catalina','Oscar','Gloria','Ivan','Marcela',
            'Cristian','Viviana','Eduardo','Patricia','Hernando','Sandra','Luis','Martha',
            'Fernando','Liliana','Rodrigo','Yolanda','Gustavo','Esperanza','Raul','Rosa',
            'Cesar','Elena','Marco','Silvia','Arturo','Beatriz','Roberto','Carmen',
            'Hector','Pilar','Ernesto','Amparo','Ignacio','Consuelo','Enrique','Teresa',
            'Leonardo','Nora','Manuel','Luz','Antonio','Helena','Francisco','Alba',
        ];

        $apellidos = [
            'García','Rodríguez','Martínez','López','González','Pérez','Sánchez','Ramírez',
            'Torres','Flores','Rivera','Gómez','Díaz','Cruz','Reyes','Morales',
            'Jiménez','Herrera','Medina','Vargas','Castillo','Ramos','Ortiz','Ruiz',
            'Mendoza','Guerrero','Salinas','Romero','Navarro','Molina','Suárez','Gutiérrez',
            'Núñez','Vega','Delgado','Cabrera','Aguilar','Fuentes','Espinoza','Castro',
            'Acosta','Lozano','Pardo','Valencia','Quintero','Rojas','Pacheco','Cárdenas',
            'Bermúdez','Orozco','Arango','Cardona','Londoño','Giraldo','Ospina','Zapata',
            'Muñoz','Cano','Franco','Mejía','Rios','Nieto','Peña','Ocampo',
        ];

        $relaciones = [
            'Hermano', 'Hermana', 'Amigo', 'Amiga', 'Primo', 'Prima', 'Vecino', 'Vecina',
            'Compañero de trabajo', 'Compañera de trabajo', 'Conocido', 'Familiar',
            'Esposo', 'Esposa', 'Hijo', 'Hija', 'Ninguna', 'No aplica',
            'Hermana en Cristo', 'Colega', 'Estudiante', 'A penas le estoy conociendo',
        ];

        $evangelistas = [
            'Lina Camila Ruiz Méndez', 'Rosa Leonor Ubilla Flores', 'Sara González',
            'María Torres', 'Ana Rodríguez', 'Patricia Gómez', 'Claudia Herrera',
            'Sandra Martínez', 'Viviana López', 'Carolina Pérez',
        ];

        $nacionalidades = [
            'Colombia', 'México', 'Venezuela', 'Ecuador', 'Perú', 'Chile',
            'Argentina', 'Bolivia', 'Paraguay', 'Uruguay', 'Cuba', 'Costa Rica',
            'Honduras', 'Guatemala', 'Panamá', 'República Dominicana',
        ];

        $conoceEstudiantes = [
            'Sí, conoce a varios', 'No conoce a nadie', 'Conoce a algunos',
            'Es nueva en la iglesia', 'Viene por primera vez', 'Tiene amigos aquí',
            'Vino con su familia', 'La invitaron del trabajo', 'La encontré en redes sociales',
            'Vino sola', 'N/A', 'Ninguno', 'Pocos', 'Muchos',
        ];

        $path = storage_path('app/estudiantes_prueba.csv');
        $file = fopen($path, 'w');

        // Encabezados
        fputcsv($file, [
            'nombre_completo', 'quien_invito', 'relacion_con_quien_invito',
            'evangelista_encargada', 'edad', 'fecha_nacimiento',
            'nacionalidad', 'email', 'telefono', 'conoce_estudiantes',
        ]);

        $cantidad = (int) $this->argument('cantidad');
        $this->info("Generando {$cantidad} estudiantes...");
        $bar = $this->output->createProgressBar($cantidad);
        $bar->start();

        for ($i = 1; $i <= $cantidad; $i++) {
            $nombre   = $nombres[array_rand($nombres)];
            $apellido1 = $apellidos[array_rand($apellidos)];
            $apellido2 = $apellidos[array_rand($apellidos)];
            $nombreCompleto = "$nombre $apellido1 $apellido2";

            $invitador = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)];
            $edad      = rand(15, 70);
            $año       = date('Y') - $edad;
            $mes       = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $dia       = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
            $email     = strtolower(str_replace(' ', '.', $nombreCompleto)) . $i . '@ejemplo.com';
            $telefono  = '3' . rand(100000000, 999999999);

            fputcsv($file, [
                $nombreCompleto,
                $invitador,
                $relaciones[array_rand($relaciones)],
                $evangelistas[array_rand($evangelistas)],
                $edad,
                "$año-$mes-$dia",
                $nacionalidades[array_rand($nacionalidades)],
                $email,
                $telefono,
                $conoceEstudiantes[array_rand($conoceEstudiantes)],
            ]);

            $bar->advance();
        }

        fclose($file);
        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Archivo generado en: storage/app/estudiantes_prueba.csv ({$cantidad} estudiantes)");
    }
}
