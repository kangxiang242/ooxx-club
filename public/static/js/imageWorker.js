self.onmessage = async function (e) {
    const { src, id } = e.data;

    try {
        const response = await fetch(src);
        const blob = await response.blob();
        const objectURL = URL.createObjectURL(blob);

        // 发送已加载的图片 URL 给主线程
        self.postMessage({ id, src: objectURL });
    } catch (error) {
        console.error('Worker image fetch error:', error);
    }
};
