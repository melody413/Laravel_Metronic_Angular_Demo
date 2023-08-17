import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ZeroConfigComponentComponent } from './zero-config-component.component';

describe('ZeroConfigComponentComponent', () => {
  let component: ZeroConfigComponentComponent;
  let fixture: ComponentFixture<ZeroConfigComponentComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ZeroConfigComponentComponent]
    });
    fixture = TestBed.createComponent(ZeroConfigComponentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
