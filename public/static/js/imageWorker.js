// imageWorker.js
self.onmessage = function(e) {
    const { src, id } = e.data;
    const img = new Image(); // 创建新的 Image 对象

    img.onload = function() {
        // 图片加载完成后通知主线程
        self.postMessage({ id, src });
    };

    img.src = src; // 启动图片加载
};
