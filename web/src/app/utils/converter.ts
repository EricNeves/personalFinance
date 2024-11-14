export function convertMoneyToReal(amount: number): string {
  return Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(amount)
}
