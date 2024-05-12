<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SchoolSeeder extends Seeder
{
    const COURSES = [
         'Grado sexto',
         'Grado septimo',
         'Grado optavo',
         'Grado noveno',
         'Grado decimo',
         'Grado once'
    ];

    const CATEGORIES_MAIN = [
        'Matematicas' => [
            'Números enteros, fraccionarios, decimales, porcentajes, razones y proporciones.',
            'Operaciones básicas con números reales.',
            'Potenciación y radicación.',
            'Ecuaciones y sistemas de ecuaciones lineales y no lineales.',
            'Desigualdades lineales y no lineales.',
            'Ángulos, triángulos, cuadriláteros y círculos.',
            'Áreas y volúmenes de figuras planas y espaciales.',
            'Relaciones de congruencia y semejanza.',
            'Teoremas clásicos como el de Pitágoras y Tales.',
            'Identidades trigonométricas.',
            'Funciones trigonométricas: seno, coseno, tangente.',
            'Resolución de triángulos.',
            'Visualización y representación de objetos en el espacio.',
            'Reconocimiento de formas y patrones geométricos.',
            'Resolución de problemas que requieren percepción espacial.'
        ],
        'Lectura Crítica' => [
            'Interpretación literal',
            'Interpretación inferencial',
            'Análisis crítico'
        ],
        'Sociales y Ciudadanas' => [
            'Comprender los conceptos fundamentales de las ciencias sociales como política',
            'economía, sociología y antropología.',
            'Analizar críticamente problemas sociales y políticos actuales.',
            'Proponer soluciones a problemas sociales y políticos de manera informada y responsable.',
            'Participar activamente en la vida ciudadana.',
            'Identificar y comprender diferentes perspectivas sobre temas sociales y políticos.',
            'Analizar críticamente argumentos y discursos.',
            'Evaluar la confiabilidad de la información.',
            'Formarse una opinión propia sobre temas sociales y políticos.',
            'Sistema económico colombiano: características y desafíos.',
            'Sectores económicos: primario, secundario y terciario.',
            'Políticas públicas económicas.',
            'Colombia en el contexto internacional.'


        ],
        'Ciencias Naturales' => [
            'Estructura y función de las células procariotas y eucariotas, procesos celulares como la respiración celular, la fotosíntesis y la división celular, genética y herencia, evolución y biodiversidad.',
            'Anatomía, fisiología y reproducción de plantas y animales, ecología y relaciones entre organismos, biomas y ecosistemas, problemas ambientales y su impacto en la salud humana.',
            'Materia y energía: Propiedades de la materia, estados de la materia, cambios físicos y químicos, energía y sus transformaciones.',
            'Estructura atómica y molecular: El átomo, enlaces químicos, tipos de moléculas, nomenclatura química.',
            'Reacciones químicas: Ecuaciones químicas, estequiometría, termodinámica y equilibrio químico.',
            'Química orgánica: Hidrocarburos, grupos funcionales, biomoléculas como carbohidratos, lípidos, proteínas y ácidos nucleicos.'
        ],
        'Inglés' => [
            'Leer y comprender textos cortos y medianos de diversos géneros (artículos periodísticos, correos electrónicos, instrucciones, etc.).',
            'Identificar la idea principal y los detalles relevantes de un texto.',
            'Comprender el significado de palabras y expresiones nuevas a partir del contexto.',
            'Traducir información de manera precisa y fluida.',
            'Facilitar la comunicación entre dos personas.'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Register courses
        foreach (self::COURSES as $row) {
            DB::table('courses')->insert([
                'name' => $row
            ]);
        }
        // Register school
        $schoolId = DB::table('schools')->insertGetId([
            'name' => 'Colegio Parroquial Señor de los Milagros',
            'address' => 'Avenida siempre viva',
            'description' => 'Colegio de pruebas',
            'city_id' => 1
        ]);
        //Add curses to school
        $rows = DB::table('courses')->select(['id'])->get();
        foreach ($rows as $row) {
            DB::table('courses_schools')->insert([
                'course_id' => $row->id,
                'school_id' => $schoolId
            ]);
        }
        //Register to main category
        foreach (self::CATEGORIES_MAIN as $key=>$rows) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => $key,
                'level' => 1
            ]);
            foreach ($rows as $row){
                DB::table('categories')->insert([
                    'name' => $row,
                    'parent_id' => $categoryId,
                ]);
            }
        }

    }
}
