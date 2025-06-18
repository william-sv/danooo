// src/composables/useOrientation.js
import { ref, onBeforeUnmount } from 'vue'

export default function useOrientation(options = {}) {
  const config = {
    target: document.getElementById(options.target) || document.documentElement,
    classPrefix: options.classPrefix || 'orientation-',
    debounce: options.debounce || 200,
    callback: options.callback || null
  }
  const orientation = ref(null)
  let timeoutId = null
  let watcher = null

  const checkOrientation = () => {
    const width = window.innerWidth
    const height = window.innerHeight
    const newOrientation = width > height ? 'width' : 'height'

    if (orientation.value !== newOrientation) {
      orientation.value = newOrientation
      
      // 更新类名
      if (config.target) {
        config.target.classList.remove(`${config.classPrefix}width`, `${config.classPrefix}height`)
        config.target.classList.add(`${config.classPrefix}${newOrientation}`)
      }

      config.callback?.(newOrientation, { width, height })
    }
  }

  const init = () => {
    if (typeof config.target === 'string') {
      config.target = document.querySelector(config.target) || document.documentElement
    }

    const handler = () => {
      clearTimeout(timeoutId)
      timeoutId = setTimeout(checkOrientation, config.debounce)
    }

    window.addEventListener('resize', handler)
    window.addEventListener('orientationchange', handler)
    checkOrientation()

    watcher = {
      destroy: () => {
        window.removeEventListener('resize', handler)
        window.removeEventListener('orientationchange', handler)
        clearTimeout(timeoutId)
      }
    }
  }

  // 客户端环境初始化
  if (typeof window !== 'undefined') {
    init()
    onBeforeUnmount(() => watcher?.destroy())
  }

  return {
    orientation,
    isWidthLonger: () => orientation.value === 'width',
    isHeightLonger: () => orientation.value === 'height'
  }
}