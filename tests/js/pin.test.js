/**
 * START OF FILE: tests/js/pin.test.js
 * Purpose: Vitest unit test suite for PIN length and validation logic
 */

import { describe, it, expect } from 'vitest';

// START OF SUITE: PIN Validation Logic
describe('PIN Validation Logic', () => {
  /**
   * START OF TEST: validates 4 to 6 digit range
   */
  it('should accept valid 4 to 6 numeric digits', () => {
    const isValidPin = (pin) => /^\d{4,6}$/.test(pin);

    expect(isValidPin('1234')).toBe(true);
    expect(isValidPin('12345')).toBe(true);
    expect(isValidPin('123456')).toBe(true);

    expect(isValidPin('123')).toBe(false);
    expect(isValidPin('1234567')).toBe(false);
    expect(isValidPin('abcd')).toBe(false);
    expect(isValidPin('')).toBe(false);
  });
  // END OF TEST

  /**
   * START OF TEST: validates Philippine mobile number normalization
   */
  it('should normalize Philippine mobile phone number', () => {
    const normalizePhone = (input) => {
      let cleaned = input.replace(/\D/g, '');
      if (cleaned.startsWith('63')) {
        cleaned = '0' + cleaned.substring(2);
      }
      return cleaned;
    };

    expect(normalizePhone('0917 123 4567')).toBe('09171234567');
    expect(normalizePhone('+63 917 123 4567')).toBe('09171234567');
    expect(normalizePhone('0917-123-4567')).toBe('09171234567');
  });
  // END OF TEST
});
// END OF SUITE

/**
 * END OF FILE: tests/js/pin.test.js
 */
