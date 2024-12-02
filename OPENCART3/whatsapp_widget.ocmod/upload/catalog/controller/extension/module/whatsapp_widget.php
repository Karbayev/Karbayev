<?php
class ControllerExtensionModuleWhatsappWidget extends Controller {
    public function index() {
        if ($this->config->get('whatsapp_widget_status')) {
            $phoneNumber = $this->config->get('whatsapp_widget_phone_number');
            $textList = $this->config->get('whatsapp_widget_text_list');

            // Разбиваем строку на массив
            $textArray = $textList ? explode(',', $textList) : [];
            
            // Выбираем случайный текст
            $randomText = $textArray ? trim($textArray[array_rand($textArray)]) : '';

            $data['phone_number'] = $phoneNumber;
            $data['random_text'] = $randomText;

            return $this->load->view('extension/module/whatsapp_widget', $data);
        }
    }
}
