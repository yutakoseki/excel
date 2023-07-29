$(document).ready(function () {
    $("#uploadForm").submit(function (e) {
        e.preventDefault();

        // 既存のファイルの削除
        $.ajax({
            url: "delete.php",
            type: "POST",
            data: {
                files: ["excel/import.xlsx", "result/result.xlsx"], // 削除したいファイル名の配列を指定
            },
            success: function (response) {
                console.log(response);

                // ファイルのアップロード
                var formData = new FormData();
                formData.append("file", $("#fileInput")[0].files[0]);

                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // ファイルの処理が成功した場合の処理
                        console.log(response);
                        $("#result").html("ファイルのアップロードが完了しました");
                    },
                    error: function (xhr, status, error) {
                        // エラーが発生した場合の処理
                        console.log(error);
                        $("#result").html("ファイルのアップロードが失敗しました");
                    },
                });
            },
            error: function (xhr, status, error) {
                console.log(error);
                $("#result").html("ファイルのアップロードが失敗しました");
            },
        });
    });
});
