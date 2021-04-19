<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class Utils_model extends CI_Model {
    public function pushAlertMessage($status = 'info', $content = 'Default')
    {
        $contentTemplate = '// BEGIN: Custom Use
            setTimeout(function() {
                toastr.' . $status . '(
                     "' . trim($content) . '",
                    "👋 System Alert !", {
                        closeButton: !0,
                        tapToDismiss: !1
                    }
                );
            }, 1e2);
            // END: Custom Used';

        $this->session->set_flashdata('message', $contentTemplate);
    }
    

}

/* End of file Utils_model.php */
