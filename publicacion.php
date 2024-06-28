<?php 
include('admin/config.php');

// Llamado General
$sql = "SELECT * FROM publicaciones P LEFT JOIN usuarios U ON P.usuarios_id = U.usuarios_id WHERE P.publicaciones_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Llamado Descripción
for ($i=0; $i < count($data); $i++) {

    $title = $data[$i]['pub_descripcion'];
    $data[$i]['pub_descripcion'] = '<b>'.$data[$i]['pub_descripcion'].'</b>';

    $sql = "SELECT * FROM publicaciones_carreras P LEFT JOIN carreras C ON P.carreras_id = C.carreras_id WHERE P.publicaciones_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$data[$i]['publicaciones_id']]);
    $pcarreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data[$i]['pub_descripcion'] .= (count($pcarreras) == 1) ? '<br>Llamado a la carrera:<br>' : '<br>Llamado a las carreras:<br>';
    
    // Loop por cada carrera
    for ($x=0; $x < count($pcarreras); $x++) {
        $sql = "SELECT * FROM publicaciones_carreras_anios P WHERE P.publicaciones_carreras_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$pcarreras[$x]['publicaciones_carreras_id']]);
        $panios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $anios = '';
        for ($z=0; $z < count($panios); $z++) {
            $txt = '';
            if (count($panios) == $pcarreras[$x]['car_duracion']) {
                $anios = 'Todos los años';
            } else {
                if ($z == count($panios)-1) {
                    $txt .= ' y ';
                }
                switch ($panios[$z]['pubcarani_anio']) {
                    case '1':
                        $txt .= 'Primer';
                        break;
                    case '2':
                        $txt .= 'Segundo';
                        break;
                    case '3':
                        $txt .= 'Tercer';
                        break;
                    case '4':
                        $txt .= 'Cuarto';
                        break;
                    case '5':
                        $txt .= 'Quinto';
                        break;
                    case '6':
                        $txt .= 'Sexto';
                        break;
                    case '7':
                        $txt .= 'Septimo';
                        break;
                }
                $txt = ($z != 0) ? strtolower($txt) : $txt;

                if ($z == count($panios)-1) {
                    $anios .= $txt.' año';
                } else {
                    $anios .= $txt.', ';
                }
            }
        }

        $data[$i]['pub_descripcion'] .= ' - ' . $pcarreras[$x]['car_nombre'] . ': ' . $anios;
        if ($z != count($panios)-1) {
            $data[$i]['pub_descripcion'] .= '<br>';
        }
    }
}


$css1 = "index.css";
include('views/publicacion.view.php');
?>