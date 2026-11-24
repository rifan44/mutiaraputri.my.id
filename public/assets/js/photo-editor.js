(() => {
  const form = document.querySelector('#profile-form');
  const input = document.querySelector('#avatar');
  const editor = document.querySelector('#photo-editor');
  const stage = document.querySelector('#photo-crop-stage');
  const image = document.querySelector('#avatar-crop-image');
  const ratioInput = document.querySelector('#avatar-ratio');
  const zoomInput = document.querySelector('#avatar-zoom');
  const zoomValue = document.querySelector('#avatar-zoom-value');
  const resetButton = document.querySelector('#photo-crop-reset');
  const status = document.querySelector('#photo-status');
  const saveButton = form?.querySelector('button[type="submit"]');

  if (!form || !input || !editor || !stage || !image || !ratioInput || !zoomInput || !zoomValue || !resetButton || !status) return;

  let zoom = 1;
  let offsetX = 0;
  let offsetY = 0;
  let dirty = false;
  let loading = false;
  let dragging = false;
  let dragStartX = 0;
  let dragStartY = 0;
  let dragOffsetX = 0;
  let dragOffsetY = 0;
  let activeObjectUrl = null;

  const ratio = () => Math.max(0.5, Math.min(1.5, Number.parseFloat(ratioInput.value) || 0.8));
  const setStatus = (message, isError = false) => {
    status.textContent = message;
    status.classList.toggle('is-error', isError);
  };

  const fitScale = () => Math.max(stage.clientWidth / image.naturalWidth, stage.clientHeight / image.naturalHeight);

  const drawPreview = () => {
    if (!image.naturalWidth || !stage.clientWidth || !stage.clientHeight) return;

    stage.style.aspectRatio = String(ratio());
    const baseScale = fitScale();
    const renderedWidth = image.naturalWidth * baseScale * zoom;
    const renderedHeight = image.naturalHeight * baseScale * zoom;
    const maxX = Math.max(0, (renderedWidth - stage.clientWidth) / 2);
    const maxY = Math.max(0, (renderedHeight - stage.clientHeight) / 2);
    offsetX = Math.max(-maxX, Math.min(maxX, offsetX));
    offsetY = Math.max(-maxY, Math.min(maxY, offsetY));

    image.style.width = `${renderedWidth}px`;
    image.style.height = `${renderedHeight}px`;
    image.style.transform = `translate(-50%, -50%) translate(${offsetX}px, ${offsetY}px)`;
    zoomValue.value = `${Math.round(zoom * 100)}%`;
    zoomValue.textContent = `${Math.round(zoom * 100)}%`;
  };

  const showLoadedImage = () => {
    if (!image.naturalWidth || !image.naturalHeight) return;
    loading = false;
    editor.hidden = false;
    requestAnimationFrame(drawPreview);
    setStatus(dirty ? 'Crop siap disimpan bersama profil.' : 'Foto tersimpan. Atur crop lalu simpan untuk memperbarui.');
  };

  image.addEventListener('load', showLoadedImage);
  image.addEventListener('error', () => {
    loading = false;
    setStatus('Foto tidak dapat dibuka. Pilih gambar JPG, PNG, atau WebP yang valid.', true);
  });

  if (image.complete && image.naturalWidth) showLoadedImage();

  input.addEventListener('change', () => {
    const file = input.files?.[0];
    if (!file) return;

    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
      input.value = '';
      setStatus('Gunakan foto berformat JPG, PNG, atau WebP.', true);
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      input.value = '';
      setStatus('Ukuran foto maksimal 5 MB.', true);
      return;
    }

    if (activeObjectUrl) URL.revokeObjectURL(activeObjectUrl);
    activeObjectUrl = URL.createObjectURL(file);
    loading = true;
    dirty = true;
    zoom = 1;
    offsetX = 0;
    offsetY = 0;
    editor.hidden = false;
    setStatus('Memuat pratinjau foto...');
    image.src = activeObjectUrl;
  });

  ratioInput.addEventListener('change', () => {
    dirty = true;
    drawPreview();
    setStatus('Rasio crop diperbarui. Simpan profil untuk menerapkan crop.');
  });

  zoomInput.addEventListener('input', () => {
    zoom = Number.parseFloat(zoomInput.value) || 1;
    dirty = true;
    drawPreview();
    setStatus('Posisi crop diperbarui. Simpan profil untuk menerapkan crop.');
  });

  resetButton.addEventListener('click', () => {
    zoom = 1;
    offsetX = 0;
    offsetY = 0;
    zoomInput.value = '1';
    dirty = true;
    drawPreview();
    setStatus('Foto disesuaikan otomatis dengan bingkai.');
  });

  stage.addEventListener('pointerdown', (event) => {
    if (!image.naturalWidth) return;
    dragging = true;
    dragStartX = event.clientX;
    dragStartY = event.clientY;
    dragOffsetX = offsetX;
    dragOffsetY = offsetY;
    stage.classList.add('is-dragging');
    stage.setPointerCapture(event.pointerId);
  });

  stage.addEventListener('pointermove', (event) => {
    if (!dragging) return;
    offsetX = dragOffsetX + event.clientX - dragStartX;
    offsetY = dragOffsetY + event.clientY - dragStartY;
    dirty = true;
    drawPreview();
    setStatus('Posisi crop diperbarui. Simpan profil untuk menerapkan crop.');
  });

  const endDrag = () => {
    dragging = false;
    stage.classList.remove('is-dragging');
  };
  stage.addEventListener('pointerup', endDrag);
  stage.addEventListener('pointercancel', endDrag);
  stage.addEventListener('lostpointercapture', endDrag);
  window.addEventListener('resize', drawPreview);

  form.addEventListener('submit', (event) => {
    if (!dirty) return;

    event.preventDefault();
    if (loading || !image.complete || !image.naturalWidth) {
      setStatus('Tunggu sampai pratinjau foto selesai dimuat.', true);
      return;
    }

    if (saveButton) saveButton.disabled = true;
    setStatus('Menyiapkan foto hasil crop...');

    const outputWidth = 1000;
    const outputHeight = Math.round(outputWidth / ratio());
    const canvas = document.createElement('canvas');
    canvas.width = outputWidth;
    canvas.height = outputHeight;

    const context = canvas.getContext('2d');
    if (!context) {
      if (saveButton) saveButton.disabled = false;
      setStatus('Editor foto tidak tersedia di browser ini.', true);
      return;
    }

    const stageWidth = stage.clientWidth;
    const stageHeight = stage.clientHeight;
    const outputScale = outputWidth / stageWidth;
    const renderedWidth = image.naturalWidth * fitScale() * zoom;
    const renderedHeight = image.naturalHeight * fitScale() * zoom;
    const left = (stageWidth / 2 + offsetX - renderedWidth / 2) * outputScale;
    const top = (stageHeight / 2 + offsetY - renderedHeight / 2) * outputScale;

    context.fillStyle = '#f5f2e9';
    context.fillRect(0, 0, outputWidth, outputHeight);
    context.drawImage(image, left, top, renderedWidth * outputScale, renderedHeight * outputScale);

    canvas.toBlob((blob) => {
      if (!blob) {
        if (saveButton) saveButton.disabled = false;
        setStatus('Foto belum bisa diproses. Coba pilih gambar lain.', true);
        return;
      }

      const croppedFile = new File([blob], 'profile-photo.jpg', { type: 'image/jpeg' });
      const transfer = new DataTransfer();
      transfer.items.add(croppedFile);
      input.files = transfer.files;
      dirty = false;
      if (saveButton) saveButton.disabled = false;
      form.requestSubmit();
    }, 'image/jpeg', 0.92);
  });
})();
