import { ref } from 'vue'

export function useProductPreviewHover() {
  const hoveredProductId = ref(null)
  const previewHideTimer = ref(null)

  const clearPreviewHideTimer = () => {
    if (previewHideTimer.value) {
      clearTimeout(previewHideTimer.value)
      previewHideTimer.value = null
    }
  }

  const schedulePreviewHide = () => {
    clearPreviewHideTimer()
    previewHideTimer.value = setTimeout(() => {
      hoveredProductId.value = null
      previewHideTimer.value = null
    }, 200)
  }

  const handleProductHover = (productId) => {
    clearPreviewHideTimer()

    if (productId === null) {
      schedulePreviewHide()
      return
    }

    hoveredProductId.value = productId
  }

  return {
    hoveredProductId,
    clearPreviewHideTimer,
    schedulePreviewHide,
    handleProductHover
  }
}
