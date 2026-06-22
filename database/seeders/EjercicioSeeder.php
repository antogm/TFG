<?php

namespace Database\Seeders;

use App\Models\Ejercicio;
use Illuminate\Database\Seeder;

class EjercicioSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->ejercicios() as $ejercicioData) {
            Ejercicio::updateOrCreate(
                ['nombre' => $ejercicioData['nombre']],
                $ejercicioData
            );
        }
    }

    private function ejercicios(): array
    {
        return [
            [
                'nombre' => 'Sentadilla con barra',
                'descripcion' => 'Apoya la barra en la espalda alta, baja con control hasta una sentadilla profunda y sube empujando con todo el pie.',
                'grupo_muscular' => 19,
                'link_youtube' => 'https://www.youtube.com/watch?v=dsCuiccYNGs&pp=ygUUc2VudGFkaWxsYSBjb24gYmFycmE%3D',
            ],
            [
                'nombre' => 'Sentadilla frontal',
                'descripcion' => 'Sujeta la barra delante de los hombros, mantén el torso erguido y baja controlando rodillas y cadera.',
                'grupo_muscular' => 19,
                'link_youtube' => 'https://www.youtube.com/watch?v=v_nvYjpX-iY&pp=ygUSc2VudGFkaWxsYSBmcm9udGFs',
            ],
            [
                'nombre' => 'Sentadilla goblet',
                'descripcion' => 'Abraza una mancuerna o kettlebell al pecho y realiza la sentadilla manteniendo el tronco estable.',
                'grupo_muscular' => 19,
                'link_youtube' => 'https://www.youtube.com/watch?v=AkC_dd9xadY&pp=ygURc2VudGFkaWxsYSBnb2JsZXQ%3D',
            ],
            [
                'nombre' => 'Prensa de piernas',
                'descripcion' => 'Empuja la plataforma con los pies sin despegar la cadera del respaldo y controla la bajada.',
                'grupo_muscular' => 19,
                'link_youtube' => 'https://www.youtube.com/watch?v=xvCynwyNoP4&pp=ygURcHJlbnNhIGRlIHBpZXJuYXM%3D',
            ],
            [
                'nombre' => 'Zancadas caminando',
                'descripcion' => 'Da un paso largo, flexiona ambas rodillas y alterna las piernas manteniendo el equilibrio.',
                'grupo_muscular' => 19,
                'link_youtube' => 'https://www.youtube.com/watch?v=Xcfs_3DMKlc&pp=ygURemFuY2FkYSBjYW1pbmFuZG8%3D',
            ],
            [
                'nombre' => 'Step-up con mancuernas',
                'descripcion' => 'Sube a un cajón o banco empujando con la pierna adelantada y controla la bajada.',
                'grupo_muscular' => 19,
                'link_youtube' => 'https://www.youtube.com/watch?v=9ZknEYboBOQ&pp=ugMGCgJlcxABugUEEgJlc8oFFnN0ZXAtdXAgY29uIG1hbmN1ZXJuYXPYBwE%3D',
            ],
            [
                'nombre' => 'Peso muerto rumano',
                'descripcion' => 'Desliza la cadera hacia atrás con ligera flexión de rodillas y vuelve extendiendo la cadera.',
                'grupo_muscular' => 20,
                'link_youtube' => 'https://www.youtube.com/watch?v=x7W2BOKWWKs&pp=ygUScGVzbyBtdWVydG8gcnVtYW5v',
            ],
            [
                'nombre' => 'Peso muerto convencional',
                'descripcion' => 'Levanta la barra desde el suelo empujando con piernas y cadera mientras mantienes la espalda neutra.',
                'grupo_muscular' => 20,
                'link_youtube' => 'https://www.youtube.com/watch?v=0XL4cZR2Ink&pp=ygUVcGVzbyBtdWVydG8gY29uIGJhcnJh',
            ],
            [
                'nombre' => 'Buenos dias con barra',
                'descripcion' => 'Con la barra en la espalda, inclina el torso desde la cadera y vuelve contrayendo glúteos e isquios.',
                'grupo_muscular' => 20,
                'link_youtube' => 'https://www.youtube.com/watch?v=dpfRXzAh7OE&pp=ygUVYnVlbm9zIGRpYXMgY29uIGJhcnJh',
            ],
            [
                'nombre' => 'Curl femoral tumbado',
                'descripcion' => 'Flexiona las rodillas en la máquina acercando los talones al glúteo sin despegar la pelvis.',
                'grupo_muscular' => 20,
                'link_youtube' => 'https://www.youtube.com/watch?v=9xbBr5Ytl8c&pp=ygUUY3VybCBmZW1vcmFsIHR1bWJhZG8%3D',
            ],
            [
                'nombre' => 'Extension de cuadriceps',
                'descripcion' => 'Extiende las rodillas en la máquina hasta arriba y baja con control evitando impulsos.',
                'grupo_muscular' => 19,
                'link_youtube' => 'https://www.youtube.com/watch?v=MyeQ1zCcfas&pp=ygUiZXh0ZW5zaW9uIGRlIGN1YWRyaWNlcHMgZW4gbWFxdWluYQ%3D%3D',
            ],
            [
                'nombre' => 'Hip thrust con barra',
                'descripcion' => 'Apoya la espalda alta en un banco, eleva la cadera con la barra y aprieta glúteos arriba.',
                'grupo_muscular' => 24,
                'link_youtube' => 'https://www.youtube.com/watch?v=tu3w5HbLgoU&pp=ygUUaGlwLXRocnVzdCBjb24gYmFycmE%3D',
            ],
            [
                'nombre' => 'Aductores en maquina',
                'descripcion' => 'Cierra las piernas contra la resistencia de la máquina controlando también la apertura.',
                'grupo_muscular' => 21,
                'link_youtube' => 'https://www.youtube.com/watch?v=fItDiXXZyZo&pp=ygUUYWR1Y3RvcmVzIGVuIG1hcXVpbmE%3D',
            ],
            [
                'nombre' => 'Abductores en maquina',
                'descripcion' => 'Abre las piernas contra la resistencia manteniendo la pelvis estable y el tronco quieto.',
                'grupo_muscular' => 22,
                'link_youtube' => 'https://www.youtube.com/watch?v=-g5AF8wA740&pp=ygUVYWJkdWN0b3JlcyBlbiBtYXF1aW5h',
            ],
            [
                'nombre' => 'Elevacion de talones de pie',
                'descripcion' => 'Eleva los talones al máximo desde la punta de los pies y desciende lentamente.',
                'grupo_muscular' => 23,
                'link_youtube' => 'https://www.youtube.com/watch?v=6tqRg_tsi3o&pp=ygUbZWxldmFjaW9uIGRlIHRhbG9uZXMgZGUgcGll',
            ],
            [
                'nombre' => 'Elevacion de talones sentado',
                'descripcion' => 'Realiza la elevación de talones sentado para enfatizar el trabajo del sóleo.',
                'grupo_muscular' => 23,
                'link_youtube' => 'https://www.youtube.com/watch?v=rHFCvBBnamU&pp=ygUcZWxldmFjaW9uIGRlIHRhbG9uZXMgc2VudGFkbw%3D%3D',
            ],
            [
                'nombre' => 'Press de banca plano',
                'descripcion' => 'Baja la barra al pecho con control y empújala arriba manteniendo escápulas retraídas.',
                'grupo_muscular' => 3,
                'link_youtube' => 'https://www.youtube.com/watch?v=fqsTgdTPRQU&pp=ygUUcHJlc3MgZGUgYmFuY2EgcGxhbm8%3D',
            ],
            [
                'nombre' => 'Press inclinado con mancuernas',
                'descripcion' => 'Empuja las mancuernas desde un banco inclinado sin perder estabilidad en hombros y escápulas.',
                'grupo_muscular' => 2,
                'link_youtube' => 'https://www.youtube.com/watch?v=qhKStczz27Q&pp=ygUecHJlc3MgaW5jbGluYWRvIGNvbiBtYW5jdWVybmFz',
            ],
            [
                'nombre' => 'Press declinado con barra',
                'descripcion' => 'Desciende la barra al pecho inferior desde banco declinado y extiende los brazos con control.',
                'grupo_muscular' => 4,
                'link_youtube' => 'https://www.youtube.com/watch?v=L1U8yy4OqbQ&pp=ygUZcHJlc3MgZGVjbGluYWRvIGNvbiBiYXJyYQ%3D%3D',
            ],
            [
                'nombre' => 'Aperturas con mancuernas',
                'descripcion' => 'Abre los brazos en arco sobre un banco plano y cierra sin golpear las mancuernas.',
                'grupo_muscular' => 3,
                'link_youtube' => 'https://www.youtube.com/watch?v=OrlXQdNwNwM&pp=ygUYYXBlcnR1cmFzIGNvbiBtYW5jdWVybmFz',
            ],
            [
                'nombre' => 'Apertura de pecho en máquina',
                'descripcion' => 'Abre los brazos en arco, intenta mantenerlos firmes y cierra sin llegar a chocar las manos.',
                'grupo_muscular' => 3,
                'link_youtube' => 'https://www.youtube.com/watch?v=Om6ABTzZrQY&pp=ygUcYXBlcnR1cmEgZGUgcGVjaG8gZW4gbWFxdWluYdIHCQkDCwGHKiGM7w%3D%3D',
            ],
            [
                'nombre' => 'Aperturas inclinadas con mancuernas',
                'descripcion' => 'Ejecuta aperturas sobre banco inclinado para focalizar la parte alta del pecho.',
                'grupo_muscular' => 2,
                'link_youtube' => 'https://www.youtube.com/watch?v=xaV9Kne7LS8&pp=ygUjYXBlcnR1cmFzIGluY2xpbmFkYXMgY29uIG1hbmN1ZXJuYXM%3D',
            ],
            [
                'nombre' => 'Cruce de poleas alto a bajo',
                'descripcion' => 'Cruza las poleas desde arriba hacia abajo manteniendo el pecho abierto y codos semirrígidos.',
                'grupo_muscular' => 4,
                'link_youtube' => 'https://www.youtube.com/watch?v=3te7Rt2pmFI&pp=ygUUY3J1Y2UgZGUgcG9sZWFzIGFsdG8%3D',
            ],
            [
                'nombre' => 'Cruce de poleas bajo a alto',
                'descripcion' => 'Lleva las asas desde abajo hacia arriba buscando una contracción alta del pectoral.',
                'grupo_muscular' => 2,
                'link_youtube' => 'https://www.youtube.com/watch?v=ANT0ebxGi5w&pp=ygUUY3J1Y2UgZGUgcG9sZWFzIGFsdG8%3D',
            ],
            [
                'nombre' => 'Fondos en paralelas',
                'descripcion' => 'Desciende entre barras con control y empuja arriba inclinando el torso si buscas más pecho.',
                'grupo_muscular' => 4,
                'link_youtube' => 'https://www.youtube.com/watch?v=fJ5QdPGMkiY&pp=ygUTZm9uZG9zIGVuIHBhcmFsZWxhcw%3D%3D',
            ],
            [
                'nombre' => 'Flexiones de brazos',
                'descripcion' => 'Mantén el cuerpo en bloque, baja el pecho cerca del suelo y empuja extendiendo los brazos.',
                'grupo_muscular' => 3,
                'link_youtube' => 'https://www.youtube.com/watch?v=b2UagYWNErY&pp=ygUTZmxleGlvbmVzIGRlIGJyYXpvcw%3D%3D',
            ],
            [
                'nombre' => 'Pullover con mancuerna',
                'descripcion' => 'Lleva la mancuerna detrás de la cabeza con codos semiflexionados y vuelve al eje del pecho.',
                'grupo_muscular' => 6,
                'link_youtube' => 'https://www.youtube.com/watch?v=NfCTdUmWYx0&pp=ygUXcHVsbG92ZXIgY29uIG1hbmN1ZXJuYXPSBwkJAwsBhyohjO8%3D',
            ],
            [
                'nombre' => 'Dominadas pronas',
                'descripcion' => 'Cuelga en agarre prono y eleva el cuerpo hasta acercar el pecho o barbilla a la barra.',
                'grupo_muscular' => 6,
                'link_youtube' => 'https://www.youtube.com/watch?v=YoQlO1lt_7I&pp=ygUQZG9taW5hZGFzIHByb25hcw%3D%3D',
            ],
            [
                'nombre' => 'Jalon al pecho',
                'descripcion' => 'Tira de la barra al pecho llevando los codos abajo y atrás sin balancear el torso.',
                'grupo_muscular' => 6,
                'link_youtube' => 'https://www.youtube.com/watch?v=x2Y6Mb41zjY&pp=ygUOamFsb24gYWwgcGVjaG8%3D',
            ],
            [
                'nombre' => 'Jalon con agarre neutro',
                'descripcion' => 'Realiza el jalón con agarre neutro buscando recorrido largo y contracción de dorsales.',
                'grupo_muscular' => 6,
                'link_youtube' => 'https://www.youtube.com/watch?v=VUJYixXx5I8&pp=ygUZamFsb24gY29uIGFnYXJyZSBlc3RyZWNobw%3D%3D',
            ],
            [
                'nombre' => 'Remo con barra',
                'descripcion' => 'Inclina el torso, acerca la barra al abdomen y controla la vuelta sin redondear la espalda.',
                'grupo_muscular' => 6,
                'link_youtube' => 'https://www.youtube.com/watch?v=MwCJGBu8PFk&pp=ygUOcmVtbyBjb24gYmFycmE%3D',
            ],
            [
                'nombre' => 'Remo con mancuerna a una mano',
                'descripcion' => 'Apoya una mano y rodilla en banco, tira de la mancuerna hacia la cadera y baja controlado.',
                'grupo_muscular' => 6,
                'link_youtube' => 'https://www.youtube.com/watch?v=inp7pjrEY1w&pp=ygUScmVtbyBjb24gbWFuY3Vlcm5h',
            ],
            [
                'nombre' => 'Remo gironda',
                'descripcion' => 'Remo sentado en polea llevando el agarre al abdomen y manteniendo el pecho abierto.',
                'grupo_muscular' => 6,
                'link_youtube' => 'https://www.youtube.com/watch?v=e98IFQpjL88&pp=ygUMcmVtbyBnaXJvbmRh',
            ],
            [
                'nombre' => 'Face pull en polea',
                'descripcion' => 'Tira de la cuerda hacia la cara con codos altos y rotación externa de hombro.',
                'grupo_muscular' => 13,
                'link_youtube' => 'https://www.youtube.com/watch?v=UaZPhyztYNU&pp=ygUPZmFjZSBwdWxsIHBvbGVh',
            ],
            [
                'nombre' => 'Encogimientos con mancuernas',
                'descripcion' => 'Eleva los hombros verticalmente con las mancuernas a los lados y baja despacio.',
                'grupo_muscular' => 7,
                'link_youtube' => 'https://www.youtube.com/watch?v=xeJjTRIYOIM&pp=ygUcZW5jb2dpbWllbnRvcyBjb24gbWFuY3Vlcm5hcw%3D%3D',
            ],
            [
                'nombre' => 'Hiperextensiones',
                'descripcion' => 'Flexiona el tronco en el banco romano y extiéndelo alineando espalda, glúteos y cadera.',
                'grupo_muscular' => 9,
                'link_youtube' => 'https://www.youtube.com/watch?v=7F7RHILGDIE&pp=ygUQaGlwZXJleHRlbnNpb25lcw%3D%3D',
            ],
            [
                'nombre' => 'Rack pull',
                'descripcion' => 'Levanta la barra desde soportes altos enfatizando la extensión de cadera y espalda alta.',
                'grupo_muscular' => 7,
                'link_youtube' => 'https://www.youtube.com/watch?v=hVySiRANg-g&pp=ygUJcmFjayBwdWxs',
            ],
            [
                'nombre' => 'Press militar con barra de pie',
                'descripcion' => 'Empuja la barra por encima de la cabeza desde la clavícula sin arquear en exceso la zona lumbar.',
                'grupo_muscular' => 11,
                'link_youtube' => 'https://www.youtube.com/watch?v=2yjwXTZQDDI&pp=ugMGCgJlcxABugUEEgJlc8oFF3ByZXNzIG1pbGl0YXIgY29uIGJhcnJh2AcB',
            ],
            [
                'nombre' => 'Press Arnold',
                'descripcion' => 'Rota las mancuernas al subir desde delante del pecho hasta arriba con brazos extendidos.',
                'grupo_muscular' => 11,
                'link_youtube' => 'https://www.youtube.com/watch?v=pQDrcNoDNVM&pp=ugMGCgJlcxABugUEEgJlc8oFDHByZXNzIGFybm9sZNgHAQ%3D%3D',
            ],
            [
                'nombre' => 'Elevaciones laterales en polea',
                'descripcion' => 'Eleva el brazo hacia el lado hasta la altura del hombro.',
                'grupo_muscular' => 12,
                'link_youtube' => 'https://www.youtube.com/watch?v=gjUrYfNU1-M&pp=ygUeZWxldmFjaW9uZXMgbGF0ZXJhbGVzIGVuIHBvbGVh0gcJCQMLAYcqIYzv',
            ],
            [
                'nombre' => 'Elevaciones laterales con mancuernas',
                'descripcion' => 'Eleva los brazos hacia el lado hasta la altura del hombro. Sin inclinar el torso.',
                'grupo_muscular' => 12,
                'link_youtube' => 'https://www.youtube.com/watch?v=hgLpdwMtEEs&pp=ygUkZWxldmFjaW9uZXMgbGF0ZXJhbGVzIGNvbiBtYW5jdWVybmFz',
            ],
            [
                'nombre' => 'Elevaciones frontales con mancuernas',
                'descripcion' => 'Sube la carga delante del cuerpo hasta la línea de los hombros controlando la bajada.',
                'grupo_muscular' => 11,
                'link_youtube' => 'https://www.youtube.com/watch?v=O0n4ITO_288&pp=ygUkZWxldmFjaW9uZXMgZnJvbnRhbGVzIGNvbiBtYW5jdWVybmFz',
            ],
            [
                'nombre' => 'Pajaro con mancuernas',
                'descripcion' => 'Inclina el torso y abre los brazos hacia los lados para trabajar la parte posterior del hombro.',
                'grupo_muscular' => 13,
                'link_youtube' => 'https://www.youtube.com/watch?v=Jhzr4SYgXVM&pp=ygUVcGFqYXJvIGNvbiBtYW5jdWVybmFz',
            ],
            [
                'nombre' => 'Curl de biceps con barra Z',
                'descripcion' => 'Flexiona los codos para llevar la barra arriba sin adelantar los hombros ni impulsarte.',
                'grupo_muscular' => 15,
                'link_youtube' => 'https://www.youtube.com/watch?v=no-dXip-rJM&pp=ygUXY3VybCBiaWNlcHMgY29uIGJhcnJhIHo%3D',
            ],
            [
                'nombre' => 'Curl alterno con mancuernas',
                'descripcion' => 'Flexiona un brazo cada vez con supinación completa y descenso controlado.',
                'grupo_muscular' => 15,
                'link_youtube' => 'https://www.youtube.com/watch?v=OLF39uJo9YM&pp=ygUbY3VybCBhbHRlcm5vIGNvbiBtYW5jdWVybmFz',
            ],
            [
                'nombre' => 'Curl martillo con mancuernas',
                'descripcion' => 'Eleva las mancuernas con agarre neutro manteniendo las muñecas firmes.',
                'grupo_muscular' => 15,
                'link_youtube' => 'https://www.youtube.com/watch?v=OPqe0kCxmR8&pp=ugMGCgJlcxABugUEEgJlc8oFDWN1cmwgbWFydGlsbG_YBwE%3D',
            ],
            [
                'nombre' => 'Curl concentrado con mancuerna',
                'descripcion' => 'Apoya el codo en la parte interna del muslo y flexiona el brazo concentrando la contracción.',
                'grupo_muscular' => 15,
                'link_youtube' => 'https://www.youtube.com/watch?v=FrOJpldJWC4&pp=ygUeY3VybCBjb25jZW50cmFkbyBjb24gbWFuY3Vlcm5h',
            ],
            [
                'nombre' => 'Curl inverso con barra',
                'descripcion' => 'Haz el curl con agarre prono para involucrar más el braquiorradial y el antebrazo.',
                'grupo_muscular' => 17,
                'link_youtube' => 'https://www.youtube.com/watch?v=r70FSepsHIY&pp=ygUWY3VybCBpbnZlcnNvIGNvbiBiYXJyYQ%3D%3D',
            ],
            [
                'nombre' => 'Press frances',
                'descripcion' => 'Baja la barra hacia la frente o detrás de la cabeza manteniendo fijos los codos.',
                'grupo_muscular' => 16,
                'link_youtube' => 'https://www.youtube.com/watch?v=PTO862T8U7Y&pp=ygUXcHJlc3MgZnJhbmNlcyBjb24gYmFycmE%3D',
            ],
            [
                'nombre' => 'Press frances con mancuernas',
                'descripcion' => 'Baja la mancuerna hacia la frente o detrás de la cabeza manteniendo fijos los codos.',
                'grupo_muscular' => 16,
                'link_youtube' => 'https://www.youtube.com/watch?v=Rn6LgSEPsDc&pp=ygUccHJlc3MgZnJhbmNlcyBjb24gbWFuY3Vlcm5hcw%3D%3D',
            ],
            [
                'nombre' => 'Extension de triceps en polea',
                'descripcion' => 'Empuja la barra o cuerda hacia abajo extendiendo los codos sin mover los hombros.',
                'grupo_muscular' => 16,
                'link_youtube' => 'https://www.youtube.com/watch?v=Zj1h0ObPsp8&pp=ygUiZXh0ZW5zaW9uIGRlIHRyaWNwZXMgZW4gcG9sZWEgYWx0YQ%3D%3D',
            ],
            [
                'nombre' => 'Extension de triceps trasnuca en polea alta',
                'descripcion' => 'Extiende los codos por encima de la cabeza con cuerda manteniendo estable el brazo.',
                'grupo_muscular' => 16,
                'link_youtube' => 'https://www.youtube.com/watch?v=8QHpC7aEQAU&pp=ygUiZXh0ZW5zaW9uIGRlIHRyaWNwZXMgZW4gcG9sZWEgYWx0YQ%3D%3D',
            ],
            [
                'nombre' => 'Rompecraneos con mancuernas',
                'descripcion' => 'Desciende las mancuernas hacia la frente con los codos apuntando arriba y extiende con control.',
                'grupo_muscular' => 16,
                'link_youtube' => 'https://www.youtube.com/watch?v=G-rzyKCVDN8&pp=ygUMcm9tcGVjcmFuZW9z',
            ],
            [
                'nombre' => "Farmer's walk",
                'descripcion' => 'Camina erguido sosteniendo cargas pesadas a los lados sin perder postura ni agarre.',
                'grupo_muscular' => 17,
                'link_youtube' => 'https://www.youtube.com/watch?v=8OtwXwrJizk&pp=ygUMZmFybWVycyB3YWxr',
            ],
            [
                'nombre' => 'Plancha frontal',
                'descripcion' => 'Mantén el cuerpo alineado sobre antebrazos y puntas de pie sin hundir la cadera.',
                'grupo_muscular' => 25,
                'link_youtube' => 'https://www.youtube.com/watch?v=d0atctiI7Vw&pp=ygUPcGxhbmNoYSBmcm9udGFs',
            ],
            [
                'nombre' => 'Crunch en polea',
                'descripcion' => 'Flexiona el tronco desde el abdomen con cuerda en polea alta sin tirar con los brazos.',
                'grupo_muscular' => 25,
                'link_youtube' => 'https://www.youtube.com/watch?v=3-j72nCc4Tg&pp=ygUPY3J1bmNoIGVuIHBvbGVh',
            ],
            [
                'nombre' => 'Elevaciones de piernas colgado',
                'descripcion' => 'Cuelga de una barra y eleva las piernas controlando el balanceo para trabajar el abdomen.',
                'grupo_muscular' => 25,
                'link_youtube' => 'https://www.youtube.com/watch?v=mXJ5bEoh-vk&pp=ygUeZWxldmFjaW9uZXMgZGUgcGllcm5hcyBjb2xnYWRv',
            ],
            [
                'nombre' => 'Rueda abdominal',
                'descripcion' => 'Rueda hacia delante manteniendo el abdomen firme y vuelve sin colapsar la zona lumbar.',
                'grupo_muscular' => 25,
                'link_youtube' => 'https://www.youtube.com/watch?v=xIzWGVYFAH8&pp=ygUPcnVlZGEgYWJkb21pbmFs',
            ],
            [
                'nombre' => 'Crunch abdominal tumbado o en banco declinado',
                'descripcion' => 'Flexiona el tronco desde el abdomen hasta alcanzar la máxima contracción.',
                'grupo_muscular' => 25,
                'link_youtube' => 'https://www.youtube.com/watch?v=SJub6eDszec&pp=ygUgY3J1bmNoIGFiZG9taW5hbCBiYW5jbyBkZWNsaW5hZG8%3D',
            ],
        ];
    }
}
