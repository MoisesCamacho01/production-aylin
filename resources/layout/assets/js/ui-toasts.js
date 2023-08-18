/**
 * UI Toasts
 */

'use strict';

// (function () {
  // Bootstrap toasts example
  // --------------------------------------------------------------------
  const toastPlacementExample = document.querySelector('.toast-placement-ex')
  let selectedType, selectedPlacement, toastPlacement;

  // Dispose toast when open another
  function toastDispose(toast) {
    if (toast && toast._element !== null) {
      if (toastPlacementExample) {
        toastPlacementExample.classList.remove(selectedType);
        DOMTokenList.prototype.remove.apply(toastPlacementExample.classList, selectedPlacement);
      }
      toast.dispose();
    }
  }


  function toast(type = 'bg-success', title = 'sin titulo', msm = 'nada', time = 10, ubication = 'top-0 end-0') {
      if (toastPlacement) {
        toastDispose(toastPlacement);
      }
      selectedType = type;
		let valor = ubication;
      selectedPlacement = valor.split(' ');

      toastPlacementExample.classList.add(selectedType);
      DOMTokenList.prototype.add.apply(toastPlacementExample.classList, selectedPlacement);
		$('.toastTitle').html(title);
		$('.toastTime').html("Hace "+time+" min");
		$('.toast-body').html(msm);
      toastPlacement = new bootstrap.Toast(toastPlacementExample);
      toastPlacement.show();
  }


// })();
