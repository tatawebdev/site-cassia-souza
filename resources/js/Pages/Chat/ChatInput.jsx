"use client"

import { useState } from "react"
import { Send, Smile, Paperclip, Mic } from "lucide-react"

export default function ChatInput({ onSend, sending = false }) {
  const [text, setText] = useState("")

  function submit(e) {
    e.preventDefault()
    const trimmed = text.trim()
    if (!trimmed || sending) return
    onSend(trimmed)
    setText("")
  }

  return (
    <form onSubmit={submit} className="px-4 py-2 bg-card border-t border-border flex gap-2 items-center">
      <button type="button" className="p-2 text-muted-foreground hover:text-foreground transition-colors">
        <Smile size={24} />
      </button>

      <button type="button" className="p-2 text-muted-foreground hover:text-foreground transition-colors">
        <Paperclip size={24} />
      </button>

      <input
        value={text}
        onChange={(e) => setText(e.target.value)}
        className="flex-1 rounded-full border-0 bg-secondary px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
        placeholder="Digite uma mensagem"
        disabled={sending}
      />

      {text.trim() ? (
        <button
          type="submit"
          disabled={sending}
          className="p-2 rounded-full transition-colors disabled:opacity-50"
          style={{ backgroundColor: "#481e4d", color: "white" }}
        >
          {sending ? (
            <div className="h-5 w-5 border-2 border-t-white border-white/30 rounded-full animate-spin" />
          ) : (
            <Send size={20} />
          )}
        </button>
      ) : (
        <button type="button" className="p-2 text-muted-foreground hover:text-foreground transition-colors">
          <Mic size={24} />
        </button>
      )}
    </form>
  )
}
