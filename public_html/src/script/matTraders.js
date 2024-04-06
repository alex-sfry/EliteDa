export const matTraders = () => {
    const $form = $('#mt-form');

    const handleSubmit = (e) => {
        if (!$form.get(0).checkValidity()) {
            e.preventDefault();
        }
    };

    $form.on('submit', handleSubmit);
};

