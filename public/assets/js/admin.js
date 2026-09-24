/* ==========================================================================
   Админ-панель — ванильный JS без зависимостей.
   ========================================================================== */

(function () {
  'use strict';

  var $ = function (sel, root) { return (root || document).querySelector(sel); };
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

  /* --- Предпросмотр загружаемой картинки --------------------------------- */

  function initImageFields() {
    $$('.image-field').forEach(function (field) {
      var input = $('input[type="file"]', field);
      var preview = $('.image-field__preview', field);
      var removeBox = $('.image-field__remove', field);
      if (!input || !preview) return;

      input.addEventListener('change', function () {
        var file = input.files && input.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (e) { preview.src = e.target.result; };
        reader.readAsDataURL(file);
        if (removeBox) {
          var cb = $('input[type="checkbox"]', removeBox);
          if (cb) cb.checked = false;
        }
      });
    });
  }

  /* --- Повторители: список строк или пар полей ---------------------------- */

  function initRepeaters() {
    $$('[data-repeater]').forEach(function (block) {
      var list = $('[data-repeater-list]', block);
      var addBtn = $('[data-repeater-add]', block);
      var template = $('template', block);
      if (!list || !addBtn || !template) return;

      function addRow(focus) {
        var frag = template.content.cloneNode(true);
        var row = frag.querySelector('.repeater__row');
        list.appendChild(frag);
        if (focus) {
          var firstInput = list.lastElementChild.querySelector('input');
          if (firstInput) firstInput.focus();
        }
        bindRemove(list.lastElementChild);
      }

      function bindRemove(row) {
        var btn = row.querySelector('.repeater__remove');
        if (btn) btn.addEventListener('click', function () { row.remove(); });
      }

      $$('.repeater__row', list).forEach(bindRemove);
      addBtn.addEventListener('click', function () { addRow(true); });
    });
  }

  /* --- Автоподтверждение перед удалением ---------------------------------- */

  function initDeleteConfirm() {
    $$('[data-confirm]').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        if (!window.confirm(form.dataset.confirm || 'Удалить запись?')) {
          e.preventDefault();
        }
      });
    });
  }

  /* --- Автоскрытие флеш-сообщения ------------------------------------------ */

  function initFlash() {
    var flash = $('.admin-flash');
    if (!flash) return;
    setTimeout(function () {
      flash.style.transition = 'opacity .4s ease';
      flash.style.opacity = '0';
    }, 4000);
  }

  function boot() {
    initImageFields();
    initRepeaters();
    initDeleteConfirm();
    initFlash();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
