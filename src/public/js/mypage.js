document.addEventListener('DOMContentLoaded', function() {
    // タブボタンとコンテンツを取得
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    // タブボタンにクリックイベントを設定
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-target');

            // 現在のアクティブなタブを非表示にする
            tabPanes.forEach(pane => {
                pane.classList.remove('active');
            });

            // クリックされたタブのコンテンツを表示する
            document.getElementById(target).classList.add('active');
        });
    });

    // 初期表示で最初のタブをアクティブにする
    if (tabButtons.length > 0) {
        tabButtons[0].click();
    }
});