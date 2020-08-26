<table>
    <tbody>
        <tr>
            <td colspan="2"> Quarter Grade lookup </td>
        </tr>
        <?php
            $row = 41;
            $double = 0.00;
            $equal_value = 60;
            for( $qg_count=1; $qg_count<=$row ; $qg_count++ ){
        ?>
        <tr>
            <td> <?php echo number_format($double,2) ?> </td>
            <td> <?php echo $equal_value; ?> </td>
        </tr>
        <?php
                if($qg_count < 16){
                    $double = $double + 4.00;
                } else {
                    $double = $double + 1.60;
                }
                $equal_value++;
            } //die();
        ?>
    </tbody>
</table>