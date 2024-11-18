export function convertMoneyToReal(amount: number): string {
  return Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(amount)
}

export function convertDateTimeToDate(dateTime: string): string {
  return new Date(dateTime).toLocaleDateString('pt-BR');
}
