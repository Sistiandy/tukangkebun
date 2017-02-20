<?php

if (!function_exists('pretty_date')) {

    function pretty_date($date = '', $format = '', $timezone = TRUE) {
        $date_str = strtotime($date);

        if (empty($format)) {
            $date_pretty = date('l, d/m/Y H:i', $date_str);
        } else {
            $date_pretty = date($format, $date_str);
        }

        if ($timezone) {
            $date_pretty .= ' WIB';
        }

        $date_pretty = str_replace('Sunday', 'Minggu', $date_pretty);
        $date_pretty = str_replace('Monday', 'Senin', $date_pretty);
        $date_pretty = str_replace('Tuesday', 'Selasa', $date_pretty);
        $date_pretty = str_replace('Wednesday', 'Rabu', $date_pretty);
        $date_pretty = str_replace('Thursday', 'Kamis', $date_pretty);
        $date_pretty = str_replace('Friday', 'Jumat', $date_pretty);
        $date_pretty = str_replace('Saturday', 'Sabtu', $date_pretty);

        $date_pretty = str_replace('January', 'Januari', $date_pretty);
        $date_pretty = str_replace('February', 'Februari', $date_pretty);
        $date_pretty = str_replace('March', 'Maret', $date_pretty);
        $date_pretty = str_replace('April', 'April', $date_pretty);
        $date_pretty = str_replace('May', 'Mei', $date_pretty);
        $date_pretty = str_replace('June', 'Juni', $date_pretty);
        $date_pretty = str_replace('July', 'Juli', $date_pretty);
        $date_pretty = str_replace('August', 'Agustus', $date_pretty);
        $date_pretty = str_replace('September', 'September', $date_pretty);
        $date_pretty = str_replace('October', 'Oktober', $date_pretty);
        $date_pretty = str_replace('November', 'November', $date_pretty);
        $date_pretty = str_replace('December', 'Desember', $date_pretty);

        return $date_pretty;
    }

}

if (!function_exists('template_media_url')) {

    function template_media_url($name = '') {
        return base_url('media/templates/' . config_item('template') . '/' . $name);
    }

}

if (!function_exists('upload_url')) {

    function upload_url($name = '') {
        if (stristr($name, '://') !== FALSE) {
            return $name;
        } else {
            return base_url('uploads/' . $name);
        }
    }

}

if (!function_exists('media_url')) {

    function media_url($name = '') {
        return base_url('media/' . $name);
    }

}

if (!function_exists('btn_list')) {

    function btn_list($module = '', $id = NULL, $title = '') {
        return '<a href="' . site_url('admin/'.$module.'/view/'.$id) . '" data-toggle="tooltip" title="Lihat" class="text-warning"><span class="fa fa-eye"></span></a>&nbsp;' .
                '<a href="' . site_url('admin/'.$module.'/edit/'.$id) . '" data-toggle="tooltip" title="Sunting" class="text-success"><span class="fa fa-edit"></span></a>&nbsp;' .
                '<a href="#delModal' . $id . '" data-toggle="modal" class="text-danger"><span data-toggle="tooltip" title="Hapus" class="fa fa-trash"></span></a>&nbsp;'.
                '<div class="modal modal-danger fade" id="delModal'.$id.'">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin akan menghapus data ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    '.form_open('admin/'.$module.'/delete/' . $id).'
                                                    <input type="hidden" name="delName" value="'.$title.'">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                                    <button type="submit" class="btn btn-outline"><span class="fa fa-check"></span> Hapus</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>';
    }

}
?>
